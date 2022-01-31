'use strict';
console.log('radioFee');
 function priceSwitch() {
    const formBox = document.getElementById('pricing-form');
    const priceForm = document.getElementById('priceForm');
  const radioFee = document.getElementsByClassName('radioFee');
        radioFee[0].addEventListener('change', function (){
        formBox.style.display = "none";
      });
        radioFee[1].addEventListener('change', function (){
        formBox.style.display = "block";
      });
     if(priceForm ===""){
            alert("お値段を入力してください");
            return false;
        }
  }

