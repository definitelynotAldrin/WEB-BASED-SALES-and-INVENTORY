document.addEventListener('DOMContentLoaded', function () {
    const btnConfirm = document.querySelectorAll('.btn-view');
    const order_view_panel = document.querySelector('.popup-order-view');
    const btnClose = document.querySelectorAll('.btn-close');
    const popupOverlay = document.querySelector('.popup-overlay');

    btnConfirm.forEach(function(order_item){
        order_item.addEventListener('click', function(){
            popupOverlay.style.display = "block";
            order_view_panel.style.display = "block";
        });
    });

    btnClose.forEach(function(btn_close){
        btn_close.addEventListener('click', function(){
            order_view_panel.style.display = "none";
            popupOverlay.style.display = "none";
        });
    });

    popupOverlay.addEventListener('click', function(){
        order_view_panel.style.display = "none";
        popupOverlay.style.display = "none";
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const btnConfirm = document.querySelectorAll('.btn-confirm');
    const popupConfirm = document.querySelector('.popup-confirmation-container');
    const btnCancel = document.querySelectorAll('.btnCancel');
    const popupOverlay = document.querySelector('.popup-overlay');

    btnConfirm.forEach(function(confirm){
        confirm.addEventListener('click', function(){
            popupOverlay.style.display = "block";
            popupConfirm.style.display = "block";
        });
    });

    btnCancel.forEach(function(cancel){
        cancel.addEventListener('click', function(){
            popupConfirm.style.display = "none";
            popupOverlay.style.display = "none";
        });
    });

    popupOverlay.addEventListener('click', function(){
        popupConfirm.style.display = "none";
        popupOverlay.style.display = "none";
    });
});