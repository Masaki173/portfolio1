'use strict';
console.log('radioFee');

 function priceSwitch() {
    const formBox = document.getElementById('pricing-form');
  const radioFee = document.getElementsByClassName('radioFee');
   radioFee[0].checked;
  formBox.style.display = "none";
        radioFee[0].addEventListener('change', function (){
        formBox.style.display = "none";
      });
        radioFee[1].addEventListener('change', function (){
        formBox.style.display = "";
      });
  }
