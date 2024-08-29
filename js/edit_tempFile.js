document.addEventListener('DOMContentLoaded', function() {
    const btnEdits = document.querySelectorAll('.btn-edit');
    
    // Add click event listener to the button
    btnEdits.forEach(function(btnEdit){
        btnEdit.addEventListener('click', function(){
            window.location.href = '../public/edit_menu_entry.php';
        });
    });

});
