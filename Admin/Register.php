<?php
    include "../db_conn.php";
?>

<!DOCTYPE html>
<html>
    <body>
    <div class="registration-form">
        <h3>Registration Form</h3>
        <form action="register.php" method="post">
            <div>
                <label class="registration-label">First Name:</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required>            
            </div>
            <div>
                <label class="registration-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>            
            </div>
            <div>
                <label class="registration-label">Email:</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>            
            </div>  
            <div>
                <label class="registration-label">Phone Number:</label>
                <input type="text" class="form-control" name="phone_num" id="phone_num" placeholder="Phone Number" required>            
            </div>
            <div>
                <label class="registration-label">Password:</label>
                <input type="password" class="form-control" name="a_password" id="a_password" placeholder="Password"  required>            
            </div>
                    
            <div>
                <button type="submit" class="btn btn-success" name="Submit">Register</button> 
                <button type="button" class="cancel-button" onclick="window.location.href='Dashboard.php';">Cancel</button>
            </div>
        </form>
    </div>
    </body>
</html>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .registration-form {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .registration-form h3 {
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        .registration-form div {
            margin-bottom: 1rem;
        }

        .registration-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }

        .cancel-button {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            margin-left: 1rem;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }
    </style>