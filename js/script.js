jQuery(function ($) { // この中であればWordpressでも「$」が使用可能になる

  var sliderThumbnail = new Swiper('.header-menu', {
    slidesPerView: 15,
    centeredSlides: true,
    navigation: {
        nextEl: '.header-button-next',
        prevEl: '.header-button-prev',
        clickable: true,
    },
    breakpoints: {
      768: {
        slidesPerView:17,
      },
    },
  });

var slider = new Swiper('.slider', {
  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },
  allowTouchMove: false,
  navigation: {
    nextEl: '.header-button-next',
    prevEl: '.header-button-prev',
    clickable: true
},
  thumbs: {
    swiper: sliderThumbnail,
  }
});

const swiper = new Swiper('.main-page', {
  slidesPerView: 1,
  autoHeight: false,
  centeredSlides: true,
  allowTouchMove: false,
  scrollbar: {
    el: '.swiper-scrollbar',
    draggable: true,
  },
  on: {
    slideChange: function() {
      if (this.activeIndex === 0) {
        // 1枚目のスライドへ切り替えたときにoverflow:hiddenを解除
        document.body.style.overflow = '';
      } else {
        // 2枚目以降のスライドが表示されている間はoverflow:hiddenを設定
        document.body.style.overflow = 'hidden';
      }
    },
  },
});


// 初期化時に1枚目のスライドの縦スクロールを許可
swiper.slides[0].style.overflowY = 'auto';


const switchBox = document.querySelector(".switch-box");
const switchBlock = document.querySelectorAll(".modal-open figure");
const switchButton = document.querySelectorAll(".switch-button");
let columnNum = 2;
const switchBlockMargin = 20; // 左右のmargin
const switchBlockMarginVertical = 20; // 上下のmargin
let isScrolling = false;

switchButton.forEach(function (elem, index) {
  elem.addEventListener("click", function () {
    columnNum = Number(elem.dataset.columnnum);
    setItem(columnNum);
  });
});

function setItem(value) {
  const column = value;
  const switchBoxWidth = switchBox.clientWidth;
  const switchBlockWidth = (switchBoxWidth - switchBlockMargin * (column - 1)) / column;
  switchBlock.forEach(function (elem2, index2) {
    elem2.style.width = switchBlockWidth + "px";
    elem2.style.left = `${(switchBlockWidth + switchBlockMargin) * (index2 % column)}px`;
    const lineIndex = Math.floor(index2 / column);
    elem2.style.top = (elem2.offsetHeight + switchBlockMarginVertical) * lineIndex + "px";
  });
}

function handleResizeAndScroll() {
  const width = window.innerWidth;
  if (width < 768) { // スマートフォンサイズ以下の場合
    const column = Math.floor((switchBox.clientWidth - switchBlockMargin) / (switchBlock[0].clientWidth + switchBlockMargin));
    if (column !== columnNum) { // カラム数が変更された場合にだけsetItem()を呼び出す
      columnNum = column;
      setTimeout(setItem, 66, columnNum); // 66ミリ秒後にsetItem()を呼び出す
    }
  } else { // スマートフォンサイズより大きい場合
    if (columnNum !== 2) { // カラム数が変更された場合にだけsetItem()を呼び出す
      columnNum = 2;
      setTimeout(setItem, 66, columnNum); // 66ミリ秒後にsetItem()を呼び出す
    }
  }
}

var slideLinks = document.querySelectorAll('.slide-link');
for (var i = 0; i < slideLinks.length; i++) {
  slideLinks[i].addEventListener('click', function(e) {
    e.preventDefault();
    var slideNumber = parseInt(this.getAttribute('data-slide'));
    swiper.slideTo(slideNumber);
  });
}


//loading

$(document).ready(function() {
  $('.loader-slide').addClass('open');
  setTimeout(function() {
    $("#loader").remove();
  }, 2000);
});


window.addEventListener("load", () => {
  const closeModalBtns = document.querySelectorAll(".modalClose");

  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    const postId = modal.id.split('-')[1];
    const openModalBtns = document.querySelectorAll(`.post-${postId} img`);

    let modalSwiper = new Swiper(`.modal-${postId} .modal-swiper-container`, {
      autoHeight: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });

    openModalBtns.forEach((openModalBtn, i) => {
      // Check if the image has a link
      const hasLink = openModalBtn.parentElement.tagName === 'A';
      const modalInSlider = modal.querySelectorAll(".swiper-slide img")[i];

      if (!hasLink) {
        openModalBtn.classList.add('modalOpen');
        openModalBtn.dataset.modalIndex = i + 1;
        openModalBtn.addEventListener("click", (e) => {
          e.preventDefault(); // Prevent the default behavior of the anchor element

          const modalIndex = openModalBtn.dataset.modalIndex;
          modal.classList.add("is-active");

          // Must add a delay for slideTo to work correctly
          setTimeout(() => {
            modalSwiper.slideTo(modalIndex - 1, 0, false);
          }, 100);

          // Add "modal-open-body" class to the body
          document.body.classList.add("modal-open-body");

          // Check the image aspect ratio
          const aspectRatio = openModalBtn.naturalWidth / openModalBtn.naturalHeight;
          const modalContent = modal.querySelector(".modal__content");

          // Set max-width based on aspect ratio if modalContent exists
          if (modalContent) {
            if (aspectRatio > 1) {
              modalContent.style.maxWidth = '765.9px';
            } else {
              // Check window width and set max-width accordingly
              if (window.innerWidth >= 768) {
                modalContent.style.maxWidth = '31.25vw';
                modalContent.style.height = '39vw';
              } else {
                modalContent.style.maxWidth = '100%';
              }
            }
          }

          // Get the click position and scroll to the top of the modal
          const clickX = e.clientX;
          const clickY = e.clientY;
          const modalRect = modal.getBoundingClientRect();
          const offsetX = clickX - modalRect.left;
          const offsetY = clickY - modalRect.top;
          const centerX = (modal.offsetWidth - modalContent.offsetWidth) / 2;
          const centerY = (modal.offsetHeight - modalContent.offsetHeight) / 2;
          const scrollX = offsetX - centerX;
          const scrollY = offsetY - centerY;

          // Scroll to the top of the modal and reset scroll position
          modal.scrollTo(0, 0);
          window.scrollTo(0, 0);

          // Hide .modal-open class when the modal opens
          const modalOpenClass = document.querySelector(".modal-open");
          if (modalOpenClass) {
            modalOpenClass.style.display = "none";
          }

          // Set .swiper-container height to innerHeight
          const swiperContainer = document.querySelector(".swiper-container");
          const switchBox = document.querySelector(".switch-box");
          swiperContainer.style.height = `${innerHeight}px`;
          switchBox.style.overflow = "hidden"; // Hide overflowing content when the height is set
        });
      } else {
        // If the image has a link, open the link when clicked
        openModalBtn.addEventListener("click", (e) => {
          window.open(openModalBtn.parentElement.href, '_blank');
        });

        // Set the same link to the modalInSlider
        if (modalInSlider && hasLink) {
          modalInSlider.parentElement.href = openModalBtn.parentElement.href;
        }
      }
    });
  });

  closeModalBtns.forEach((closeModalBtn) => {
    closeModalBtn.addEventListener("click", () => {
      modals.forEach(modal => {
        modal.classList.remove("is-active");
        modal.style.maxHeight = innerHeight; // Reset max-height when the modal is closed

        // Reset .swiper-container height and overflow when the modal is closed
        const swiperContainer = document.querySelector(".swiper-container");
        const switchBox = document.querySelector(".switch-box");
        swiperContainer.style.height = "auto";
        switchBox.style.overflow = "visible";
      });

      // Show .modal-open class when the modal is closed
      const modalOpenClass = document.querySelector(".modal-open");
      if (modalOpenClass) {
        modalOpenClass.style.display = "flex";
      }

      // Remove "modal-open-body" class from the body and reset overflow
      document.body.classList.remove("modal-open-body");
      document.body.style.overflow = "visible";
    });
  });
});



}); //end
