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
    const menu_entry = document.querySelector('.btn-cancel');
    
    // Add click event listener to the button
    menu_entry.addEventListener('click', function(){
        window.location.href = '../public/menu_entry.php?success=Update Cancelled';
    });
 

});



document.addEventListener('DOMContentLoaded', function() {
    const settings = document.querySelector('.admin-profile');
    
    // Add click event listener to the button
    settings.addEventListener('click', function(){
        window.location.href = '../public/settings.php';
    });
 
});


document.addEventListener('DOMContentLoaded', function() {
    const inDebt = document.querySelectorAll('.in-debt-cards');
    
    // Loop through each element with the class 'in-debt-cards' and add an event listener
    inDebt.forEach(function(debtCards) {
        debtCards.addEventListener('click', function() {
            window.location.href = '../public/settlement_panel.php';
        });
    });
});

