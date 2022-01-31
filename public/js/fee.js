'use strict';
console.log('radioFee');
  const radioFee = document.getElementsByClassName('radioFee');
  const formBox = document.getElementById('pricing-form');
　radioFee[0].checked;
  formBox.style.display = "none";
 function priceSwitch() {
//     const formBox = document.getElementById('pricing-form');
//   const radioFee = document.getElementsByClassName('radioFee');
        radioFee[0].addEventListener('change', function (){
        formBox.style.display = "none";
      });
        radioFee[1].addEventListener('change', function (){
        formBox.style.display = "";
      });
  }
