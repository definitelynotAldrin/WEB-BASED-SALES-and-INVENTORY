document.addEventListener('DOMContentLoaded', function () {
    const order_items = document.querySelectorAll('.btn-view');
    const order_view_panel = document.querySelector('.popup-order-view');
    const btnClose = document.querySelectorAll('.btn-close');

    order_items.forEach(function(order_item){
        order_item.addEventListener('click', function(){
            order_view_panel.style.display = "block";
        });
    });

    btnClose.forEach(function(btn_close){
        btn_close.addEventListener('click', function(){
            order_view_panel.style.display = "none";
        });
    });
});