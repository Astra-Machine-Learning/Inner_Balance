const texts = [
    document.getElementById('text1'),
    document.getElementById('text2'),
    document.getElementById('text3'),
    document.getElementById('text4'),
    document.getElementById('text5'),
    document.getElementById('text6'),
    document.getElementById('text7'),
    document.getElementById('text8'),
    document.getElementById('text9'),
    document.getElementById('text10'),

    
];

let currentIndex = 0;

function showNextText() {
    if (currentIndex > 0) {
        texts[currentIndex - 1].classList.remove('typing');
    } else if (currentIndex === 0 && texts[texts.length - 1].classList.contains('typing')) {
        texts[texts.length - 1].classList.remove('typing');
    }

    texts[currentIndex].classList.add('typing');
    
    currentIndex = (currentIndex + 1) % texts.length;
    
    setTimeout(showNextText, 3000); // 1s typing + 1s display + 1s fade out
}

showNextText();