document.addEventListener('DOMContentLoaded', function () {
    const btnSettles = document.querySelectorAll('.btn-settle');
    const settlement = document.querySelector('.popup-settlement-paid');
    const btnClose = document.querySelectorAll('.btn-close');

    btnSettles.forEach(function(btnSettle){
        btnSettle.addEventListener('click', function(){
            settlement.style.display = "block";
        });
    });

    btnClose.forEach(function(btn_close){
        btn_close.addEventListener('click', function(){
            settlement.style.display = "none";
        });
    });
});



document.addEventListener('DOMContentLoaded', function () {
    const btnCredits = document.querySelectorAll('.btn-credit');
    const settlement = document.querySelector('.popup-settlement-credit');
    const btnClose = document.querySelectorAll('.btn-close');

    btnCredits.forEach(function(btnCredit){
        btnCredit.addEventListener('click', function(){
            settlement.style.display = "block";
        });
    });

    btnClose.forEach(function(btn_close){
        btn_close.addEventListener('click', function(){
            settlement.style.display = "none";
        });
    });
});