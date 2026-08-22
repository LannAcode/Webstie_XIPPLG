/* ==========================================================================
   TYPEWRITER ANIMATION MODULE
   ========================================================================== */

function initTypewriter() {
  const typedElement = document.querySelector('.typed-text');
  if (!typedElement) return;

  const words = [
    "SOFTWARE ENGINEERING",
    "FUTURE DEVELOPERS",
    "CODE & INNOVATION",
    "CREATIVE TECH CLASS"
  ];
  
  let wordIndex = 0;
  let charIndex = 0;
  let isDeleting = false;
  let typeSpeed = 100;

  function type() {
    const currentWord = words[wordIndex];
    
    if (isDeleting) {
      typedElement.textContent = currentWord.substring(0, charIndex - 1);
      charIndex--;
      typeSpeed = 50;
    } else {
      typedElement.textContent = currentWord.substring(0, charIndex + 1);
      charIndex++;
      typeSpeed = 120;
    }

    if (!isDeleting && charIndex === currentWord.length) {
      typeSpeed = 2000;
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      wordIndex = (wordIndex + 1) % words.length;
      typeSpeed = 500;
    }

    setTimeout(type, typeSpeed);
  }

  type();
}
