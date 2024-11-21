<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include SweetAlert library
echo '<script src="js/sweetalert.js"></script>';

// Execute database query
$sql = "SELECT p.*, GROUP_CONCAT(pi.Images) AS all_images, GROUP_CONCAT(pi.image_type) AS image_types
        FROM products_tb p 
        LEFT JOIN products_img_id pi ON p.products_id = pi.products_id
        GROUP BY p.products_id 
        ORDER BY p.products_id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<script>Swal.fire('Error', 'Error retrieving products: " . mysqli_error($conn) . "', 'error');</script>";
}

// Cache results to avoid repeated DB queries
$cachedResults = mysqli_fetch_all($result, MYSQLI_ASSOC);



function formatPeso($price)
{
    return '₱' . number_format((float)$price, 2);
}

// Determine the correct path based on the script's location 
function getImagePath($image, $pageId)
{
    if (!isset($image) || empty($image)) {
        return ''; // Return empty string if image is not set or empty
    } else {
        $nameFolder = "uploads";
        $image = ltrim($image, '/');
        return ($pageId === 1 ? "../$nameFolder/" : "./$nameFolder/") . $image;
    }
}
?>
<div id="ImageCards">
    <main>
        <section class="filter-section">
            <h2>Products Available</h2>
            <div class="filter-bar">
                <label for="filter">Filter By:</label>
                <select id="filter" onchange="filterProducts()">
                    <option value="all">All Types</option>
                    <option value="2 wheels">Bikes</option>
                    <option value="3 wheels">Trikes</option>
                    <option value="4 wheels">Quad Bikes</option>
                </select>
            </div>
        </section>
        <section class="product-grid">
            <?php foreach ($cachedResults as $row):
                $images = !empty($row['all_images']) ? explode(',', $row['all_images']) : [];
                $imageTypes = !empty($row['image_types']) ? explode(',', $row['image_types']) : [];
            ?>
                <article class="product-card" data-wheels="<?php echo htmlspecialchars($row['p_wheels']); ?>">
                    <div class="image-container">
                        <?php foreach ($images as $index => $image): ?>
                            <?php if ($imageTypes[$index] === 'cover'): ?>
                                <img src="<?php echo htmlspecialchars(getImagePath($image, $pageId)); ?>"
                                    alt="<?php echo htmlspecialchars($row['p_model']); ?>"
                                    class="product-image"
                                    loading="lazy">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="hover-overlay">
                            <button class="view-details-btn" onclick="openProductModal('<?php echo htmlspecialchars($row['products_id']); ?>')">
                                View Details
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($row['p_model']); ?></h3>
                        <p class="price"><?php echo htmlspecialchars(formatPeso($row['p_price'])); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <div class="modal-overlay" id="modal-overlay"></div>

    <?php foreach ($cachedResults as $row):
        $images = !empty($row['all_images']) ? explode(',', $row['all_images']) : [];
        $imageTypes = !empty($row['image_types']) ? explode(',', $row['image_types']) : [];
    ?>
        <div class="product-modal" id="modal-<?php echo htmlspecialchars($row['products_id']); ?>">
            <div class="modal-content">
                <header class="modal-header">
                    <h2><?php echo htmlspecialchars($row['p_model']); ?></h2>
                    <div class="modal-actions">
                        <button class="close-btn" onclick="closeModal('<?php echo htmlspecialchars($row['products_id']); ?>')">
                            &times;
                        </button>
                    </div>
                </header>

                <div class="modal-body">
                    <div class="product-gallery">
                        <div class="main-image-wrapper">
                            <button class="nav-btn prev" onclick="changeImage('<?php echo htmlspecialchars($row['products_id']); ?>', -1)">
                                &lsaquo;
                            </button>
                            <div class="main-image">
                                <?php foreach ($images as $index => $image): ?>
                                    <?php if ($imageTypes[$index] === 'cover'): ?>
                                        <img id="main-img-<?php echo htmlspecialchars($row['products_id']); ?>-<?php echo $index; ?>"
                                            src="<?php echo htmlspecialchars(getImagePath($image, $pageId)); ?>"
                                            alt="<?php echo htmlspecialchars($row['p_model']); ?>"
                                            class="product-image-modal active"
                                            loading="lazy">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php foreach ($images as $index => $image): ?>
                                    <?php if ($imageTypes[$index] === 'thumbnail'): ?>
                                        <img id="main-img-<?php echo htmlspecialchars($row['products_id']); ?>-<?php echo $index; ?>"
                                            src="<?php echo htmlspecialchars(getImagePath($image, $pageId)); ?>"
                                            alt="<?php echo htmlspecialchars($row['p_model']); ?>"
                                            class="product-image-modal hidden"
                                            loading="lazy">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <button class="nav-btn next" onclick="changeImage('<?php echo htmlspecialchars($row['products_id']); ?>', 1)">
                                &rsaquo;
                            </button>
                        </div>

                        <div class="thumbnail-strip">
                            <?php foreach ($images as $index => $image): ?>
                                <?php if ($imageTypes[$index] === 'cover'): ?>
                                    <button class="thumbnail active"
                                        onclick="selectImage('<?php echo htmlspecialchars($row['products_id']); ?>', <?php echo $index; ?>)">
                                        <img src="<?php echo htmlspecialchars(getImagePath($image, $pageId)); ?>"
                                            alt="Product thumbnail <?php echo $index + 1; ?>"
                                            loading="lazy">
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($images as $index => $image): ?>
                                <?php if ($imageTypes[$index] === 'thumbnail'): ?>
                                    <button class="thumbnail"
                                        onclick="selectImage('<?php echo htmlspecialchars($row['products_id']); ?>', <?php echo $index; ?>)">
                                        <img src="<?php echo htmlspecialchars(getImagePath($image, $pageId)); ?>"
                                            alt="Product thumbnail <?php echo $index + 1; ?>"
                                            loading="lazy">
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="product-details">
                        <h1 class="title">Product Details</h1>
                        <div class="model-tag">
                            <span>Model:</span>
                            <strong><?php echo htmlspecialchars($row['p_model']); ?></strong>
                        </div>
                        <div class="price-tag">
                            <span>Cash Price:</span>
                            <strong><?php echo htmlspecialchars(formatPeso($row['p_price'])); ?></strong>
                        </div>
                        <div class="price-tag">
                            <span>Installment Term:</span>
                            <strong>12 mos</strong>
                        </div>
                        <section class="specs">
                            <h2 class="subtitle">Specifications</h2>
                            <div class="specs-grid">
                                <?php
                                $specs = [
                                    'Wheels' => $row['p_wheels'],
                                    'Motor' => $row['p_motor_power'],
                                    'Battery' => $row['p_battery'],
                                    'Max Speed' => $row['p_max_speed'],
                                    'Range' => $row['p_range'],
                                    'Charging Time' => $row['p_charging_time'],
                                    'Availability' => $row['u_availability']
                                ];
                                foreach ($specs as $label => $value):
                                ?>
                                    <div class="spec">
                                        <span class="label"><?php echo htmlspecialchars($label); ?>:</span>
                                        <span class="value"><?php echo htmlspecialchars($value); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                        <?php if (!empty(trim($row['p_other_features'])) || !empty(trim($row['p_variants']))): ?>
                            <div class="other-specs">
                                <h1 class="title">Additional Information</h1>
                                <br>
                                <?php if (!empty(trim($row['p_variants']))): ?>
                                    <section class="colors">
                                        <div class="color-list">
                                            <h3 class="color-label">Available Colors</h3>
                                            <div class="color-value">
                                                <?php
                                                $colors = explode(',', $row['p_variants']);
                                                foreach (array_map('trim', $colors) as $color):
                                                ?>
                                                    <span class="color-tag"><?php echo htmlspecialchars($color); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </section>
                                <?php endif; ?>
                                <?php if (!empty(trim($row['p_other_features']))): ?>
                                    <section class="other-features">
                                        <h3 class="feature-label">Additional Features</h3>
                                        <div class="feature-box">
                                            <?php echo nl2br(htmlspecialchars($row['p_other_features'])); ?>
                                        </div>
                                    </section>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    // Create a single Blob URL for the worker script to avoid duplication
    const dataWorkerScript = `
    self.onmessage = function(e) {
        const { task, data } = e.data;

        switch(task) {
            case 'preloadImages':
                data.forEach(src => {
                    const img = new Image();
                    img.src = src;
                });
                self.postMessage({ task: 'preloadImagesComplete' });
                break;
            case 'fetchProductDetails':
                fetch(data.url)
                    .then(response => response.json())
                    .then(result => {
                        self.postMessage({ task: 'fetchProductDetailsComplete', data: result });
                    })
                    .catch(error => {
                        self.postMessage({ task: 'error', data: error.message });
                    });
                break;
            // Add more tasks as needed for concurrent data retrieval
        }
    };
`;

    const blob = new Blob([dataWorkerScript], {
        type: 'application/javascript'
    });
    const workerURL = URL.createObjectURL(blob);
    const dataWorker = new Worker(workerURL);

    // Handle messages from the worker
    dataWorker.onmessage = function(e) {
        const {
            task,
            data
        } = e.data;

        if (task === 'preloadImagesComplete') {
            console.log('Image preloading completed.');
        }

        if (task === 'fetchProductDetailsComplete') {
            updateProductDetailsUI(data);
        }

        if (task === 'error') {
            console.error('Worker error:', data);
        }

        // Handle more tasks as needed
    };

    // Function to update the UI with fetched product details
    function updateProductDetailsUI(productDetails) {
        const modal = document.getElementById(`modal-${productDetails.id}`);
        if (modal) {
            const nameElem = modal.querySelector('.product-name');
            const priceElem = modal.querySelector('.product-price');
            if (nameElem) nameElem.textContent = productDetails.name;
            if (priceElem) priceElem.textContent = formatPeso(productDetails.price);
            // Update other UI elements as needed
        }
    }

    // Modified functions to use worker for data retrieval
    function openProductModal(id) {
        const overlay = document.getElementById('modal-overlay');
        const modalElement = document.getElementById(`modal-${id}`);

        overlay.classList.add('active');
        if (modalElement) {
            modalElement.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Preload images using worker
            const images = Array.from(modalElement.querySelectorAll('.thumbnail img')).map(img => img.src);
            dataWorker.postMessage({
                task: 'preloadImages',
                data: images
            });

            // Fetch additional product details concurrently
            const productDetailsURL = `../api/get-product-details.php?id=${encodeURIComponent(id)}`;
            dataWorker.postMessage({
                task: 'fetchProductDetails',
                data: {
                    url: productDetailsURL
                }
            });
        }
    }

    function closeModal(id) {
        const overlay = document.getElementById('modal-overlay');
        const modalElement = document.getElementById(`modal-${id}`);

        overlay.classList.remove('active');
        if (modalElement) {
            modalElement.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    function selectImage(productId, index) {
        const modal = document.getElementById(`modal-${productId}`);
        if (modal) {
            const thumbnails = modal.querySelectorAll('.thumbnail');
            const mainImages = modal.querySelectorAll('.product-image-modal');
            const selectedThumbnail = thumbnails[index];

            thumbnails.forEach(t => t.classList.remove('active'));
            if (selectedThumbnail) selectedThumbnail.classList.add('active');

            mainImages.forEach((img, idx) => {
                img.classList.toggle('active', idx === index);
                img.classList.toggle('hidden', idx !== index);
            });
        }
    }

    function changeImage(productId, direction) {
        const modal = document.getElementById(`modal-${productId}`);
        if (modal) {
            const thumbnails = modal.querySelectorAll('.thumbnail');
            const activeIndex = Array.from(thumbnails).findIndex(t => t.classList.contains('active'));
            let newIndex = activeIndex + direction;

            if (newIndex < 0) newIndex = thumbnails.length - 1;
            if (newIndex >= thumbnails.length) newIndex = 0;

            selectImage(productId, newIndex);
        }
    }

    function filterProducts() {
        const filter = document.getElementById('filter').value;
        document.querySelectorAll('.product-card').forEach(card => {
            const wheels = card.dataset.wheels;
            card.style.display = (filter === 'all' || wheels === filter) ? 'block' : 'none';
        });
    }

    document.getElementById('modal-overlay').addEventListener('click', function(e) {
        if (e.target === this) {
            const activeModal = document.querySelector('.product-modal.active');
            if (activeModal) {
                const id = activeModal.id.replace('modal-', '');
                closeModal(id);
            }
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.product-modal.active');
            if (activeModal) {
                const id = activeModal.id.replace('modal-', '');
                closeModal(id);
            }
        }
    });
</script>
<style>
    .hidden {
        display: none;
    }

    .active {
        display: block;
    }

    .product-image-modal {
        width: 100%;
        height: auto;
    }

    .no-products {
        text-align: center;
        padding: 50px;
        margin: 20px;
        background: #f5f5f5;
        border-radius: 8px;
    }

    .no-products h2 {
        color: #666;
        margin-bottom: 10px;
    }

    .no-products p {
        color: #888;
    }
</style>