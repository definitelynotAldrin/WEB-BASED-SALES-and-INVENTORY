document.addEventListener('DOMContentLoaded', function () {
    const btnSettles = document.querySelectorAll('.btn-settle');
    const settlement = document.querySelector('.popup-settlement-paid');
    const btnClose = document.querySelectorAll('.btn-close');
    const overlay = document.querySelector('.popup-overlay');

    btnSettles.forEach(function(btnSettle){
        btnSettle.addEventListener('click', function(){
            settlement.style.display = "block";
            overlay.style.display = "block";
            // document.body.style.overflow = "hidden";
        });
    });

    btnClose.forEach(function(btn_close){
        btn_close.addEventListener('click', function(){
            settlement.style.display = "none";
            overlay.style.display = "none";
            // document.body.style.overflow = "auto";
        });
    });

    overlay.addEventListener('click', function(){
        settlement.style.display = "none";
        overlay.style.display = "none";
        // document.body.style.overflow = "auto";
    });

});



document.addEventListener('DOMContentLoaded', function () {
    const btnCredits = document.querySelectorAll('.btn-credit');
    const settlement = document.querySelector('.popup-settlement-credit');
    const btnClose = document.querySelectorAll('.btn-close');
    const overlay = document.querySelector('.popup-overlay');

    btnCredits.forEach(function(btnCredit){
        btnCredit.addEventListener('click', function(){
            settlement.style.display = "block";
            overlay.style.display = "block";
            // document.body.style.overflow = "hidden";
        });
    });

    btnClose.forEach(function(btn_close){
        btn_close.addEventListener('click', function(){
            settlement.style.display = "none";
            overlay.style.display = "none";
            // document.body.style.overflow = "auto";
        });
    });

    overlay.addEventListener('click', function(){
        settlement.style.display = "none";
        overlay.style.display = "none";
        // document.body.style.overflow = "auto";
    });
});