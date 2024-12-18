document.getElementById('login').addEventListener('click', () => {
    document.querySelector('.overlay').style.display = "block";
    document.querySelector('.loginn').style.display = "flex";
});

document.querySelector('.overlay').addEventListener('click', () => {
    document.querySelector('.overlay').style.display = "none";
    document.querySelector('.loginn').style.display = "none";
    document.querySelector('.signupp').style.display = "none";

});

document.getElementById('signup').addEventListener('click', () => {
    document.querySelector('.overlay').style.display = "block";
    document.querySelector('.signupp').style.display = "flex";
});

document.getElementById('span-login').addEventListener('click', () => {
    document.querySelector('.signupp').style.display = "none";
    document.querySelector('.overlay').style.display = "block";
    document.querySelector('.loginn').style.display = "flex";
})

document.getElementById('span-register').addEventListener('click', () => {
    document.querySelector('.loginn').style.display = "none";
    document.querySelector('.overlay').style.display = "block";
    document.querySelector('.signupp').style.display = "flex";
})

document.getElementById('invis').addEventListener('click', () => {
        document.getElementById('invis').style.display = "none"
        document.getElementById('vis').style.display = "block"
        document.getElementById('passlog').type = 'text'
})
document.getElementById('vis').addEventListener('click',()=>{
        document.getElementById('vis').style.display = "none"
        document.getElementById('invis').style.display = "block"
         document.getElementById('passlog').type = 'password'
})