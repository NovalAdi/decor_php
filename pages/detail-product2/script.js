function img(anything) {
    document.querySelector('.slide').src = anything;
}

function change(change) {
    const line = document.querySelector('.home');
    line.style.background = change;
}

// let item = document.getElementsByClassName("item-cart");

// for (let index = 0; index < item.length; index++) {

//   const element = item[index];
//   let counter = document.getElementsByClassName("counter")[index];


//   counter.children[0].addEventListener("click", () => {

//     let number = counter.children[1].getAttribute("value");
//     let intNumber = parseInt(number, 10);

//     if (intNumber!=1) {
//         counter.children[1].setAttribute("value", intNumber - 1);
//     }
//   });

//   counter.children[2].addEventListener("click", () => {

//     let number = counter.children[1].getAttribute("value");
//     let intNumber = parseInt(number, 10);

//     counter.children[1].setAttribute("value", intNumber + 1);
//   });
// }

// JavaScript