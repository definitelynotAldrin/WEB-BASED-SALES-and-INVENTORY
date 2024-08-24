document.addEventListener('DOMContentLoaded', function() {
    const collectibles = document.querySelector('.collectibles-card');
    
    // Add click event listener to the button
    collectibles.addEventListener('click', function(){
        window.location.href = '../public/collectibles.html';
    });
 

});
