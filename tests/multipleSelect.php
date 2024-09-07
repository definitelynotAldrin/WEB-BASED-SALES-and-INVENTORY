<?php
// Include database connection
include_once "../includes/connection.php";

// Fetch active menu items
$sql = "SELECT item_id, item_name FROM menu_items WHERE status = 'active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Multiple Menu Items</title>
</head>
<body>
<form action="menu_entry.php" method="POST">
    <!-- Menu Item Information -->
    <label for="menu_name">Menu Name:</label>
    <input type="text" id="menu_name" name="menu_name" required>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" step="0.01" required>

    <!-- Dynamic Stock Fields -->
    <div id="stock_fields">
        <div class="stock_entry">
            <label for="stock_1">Stock:</label>
            <select name="stocks[]" required>
                <?php
               include_once "test_connection.php";
                $query = "SELECT id, name FROM stocks";
                $result = $conn->query($query);

                // Populate the dropdown with stock options
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>

            <label for="quantity_1">Quantity Required:</label>
            <input type="number" name="quantities[]" step="0.01" required>
        </div>
    </div>

    <!-- Add and Remove Stock Buttons -->
    <button type="button" onclick="addStockField()">Add More Stocks</button>
    <button type="button" onclick="removeStockField()">Remove Last Stock</button>

    <!-- Submit Button -->
    <input type="submit" name="submit" value="Add Menu Item">
</form>

<script>
    let stockCount = 1;

    function addStockField() {
        stockCount++;
        const container = document.getElementById('stock_fields');
        const newField = document.createElement('div');
        newField.className = 'stock_entry';
        newField.id = `stock_entry_${stockCount}`;
        newField.innerHTML = `
            <label for="stock_${stockCount}">Stock:</label>
            <select name="stocks[]" required>
                <?php
                // Populate the dropdown with stock options
                $query = "SELECT id, name FROM stocks";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
            <label for="quantity_${stockCount}">Quantity Required:</label>
            <input type="number" name="quantities[]" step="0.01" required>
        `;
        container.appendChild(newField);
    }

    function removeStockField() {
        if (stockCount > 1) {  // Ensure there's at least one field remaining
            const container = document.getElementById('stock_fields');
            const lastField = document.getElementById(`stock_entry_${stockCount}`);
            container.removeChild(lastField);
            stockCount--;
        } else {
            alert("At least one stock field must remain.");
        }
    }
</script>


</body>
</html>

<?php
$conn->close();
?>
