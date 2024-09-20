document.addEventListener('DOMContentLoaded', function() {
    const collectibles = document.querySelector('.collectibles-link');
    
    // Add click event listener to the button
    collectibles.addEventListener('click', function(){
        window.location.href = '../public/collectibles.php';
    });
 

});


document.addEventListener('DOMContentLoaded', function() {
    const collectibles = document.querySelector('.sales-link');
    
    // Add click event listener to the button
    collectibles.addEventListener('click', function(){
        window.location.href = '../public/sales_report.php';
    });
 

});


document.addEventListener('DOMContentLoaded', function() {
    const collectibles = document.querySelector('.btn-cancel');
    
    // Add click event listener to the button
    collectibles.addEventListener('click', function(){
        window.location.href = '../public/menu_entry.php?success=Update Cancelled';
    });
 

});


