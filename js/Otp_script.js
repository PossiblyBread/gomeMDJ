// OTP UI State Manager
const OtpUI = {
    elements: {
        form: document.getElementById('otp-form'),
        status: document.getElementById('otp-status-message'),
        expiry: document.getElementById('otp-expiry-message'),
        wait: document.getElementById('otp-wait-message'),
        resend: document.getElementById('resend-otp-btn'),
        verify: document.getElementById('verify-otp-btn'),
        countdown: document.getElementById('countdown')
    },

    updateState({ otpSent = false, otpSentViaEmail = false, timeRemaining = 0 }) {
        // Hide all messages initially
        this.elements.expiry.style.display = 'none';
        this.elements.status.style.display = 'none';
        this.elements.wait.style.display = 'none';
        this.elements.resend.style.display = 'none';

        if (!otpSent) {
            this.elements.wait.style.display = 'block';
            return;
        }

        if (otpSentViaEmail) {
            this.elements.status.style.display = 'block';
            this.elements.expiry.style.display = 'block';
            this.elements.wait.style.display = 'none';
            
            if (timeRemaining > 0) {
                this.elements.resend.style.display = 'none';  // Hide resend until countdown hits 0
            } else {
                this.elements.resend.style.display = 'block'; // Show resend after countdown reaches 0
            }
        }
    }
};

// Request OTP with optimized handling
async function requestOtp() {
    try {
        OtpUI.updateState({ otpSent: false });
        
        const response = await fetch('Request_Otp.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        if (data.status === 'OTP sent') {
            OtpUI.updateState({ 
                otpSent: true, 
                otpSentViaEmail: true, 
                timeRemaining: data.otp_expiry - Math.floor(Date.now() / 1000) 
            });
            startCountdown(data.otp_expiry);
        } else {
            throw new Error(data.message || 'Failed to send OTP');
        }
    } catch (error) {
        console.error('Error:', error);
        OtpUI.updateState({ otpSent: false });
        alert(error.message || 'Error sending OTP. Please try again.');
    }
}

// Countdown Timer
function startCountdown(expiry) {
    clearInterval(window.countdownInterval);
    
    const updateTimer = (remainingTime) => {
        if (remainingTime <= 0) {
            clearInterval(window.countdownInterval);
            OtpUI.elements.countdown.textContent = 'Expired';
            OtpUI.updateState({ 
                otpSent: true, 
                otpSentViaEmail: true, 
                timeRemaining: 0 
            });
            return;
        }

        // Format and display time
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;
        OtpUI.elements.countdown.textContent = 
            `${minutes}:${seconds.toString().padStart(2, '0')}`;

        // Update UI state
        OtpUI.updateState({ 
            otpSent: true, 
            otpSentViaEmail: true, 
            timeRemaining: remainingTime 
        });
    };
    
    let remainingTime = expiry - Math.floor(Date.now() / 1000);
    updateTimer(remainingTime);
    
    window.countdownInterval = setInterval(() => {
        remainingTime--;
        updateTimer(remainingTime);
    }, 1000);
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Resend OTP button
    OtpUI.elements.resend.addEventListener('click', function() {
        requestOtp();
    });

    // OTP form submission
    document.getElementById('otp-verification-form').addEventListener('submit', function(event) {
        event.preventDefault();
        verifyOtp();
    });
});

// Verify OTP
function verifyOtp() {
    const otp = document.getElementById('otp').value;
    
    if (!/^\d{6}$/.test(otp)) {
        alert('Please enter a valid 6-digit OTP');
        return;
    }
    
    OtpUI.elements.verify.disabled = true;
    
    fetch('Verify_Login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'OTP verified') {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
            OtpUI.elements.verify.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error verifying OTP');
        OtpUI.elements.verify.disabled = false;
    });
}

// Back to Login Form
function backToLoginForm() {
    document.getElementById('login-form-content').style.display = 'block';
    OtpUI.elements.form.style.display = 'none';
    clearInterval(window.countdownInterval);
    OtpUI.updateState({ otpSent: false });
}
