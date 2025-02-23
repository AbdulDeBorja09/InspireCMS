<style>
    /* PRELOADER */
    .preloader {
        background-color: #003e7c;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #003e7c;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9000;
        opacity: 1;
        transition: opacity 1s ease-out;
    }

    .preloader.fade-out {
        opacity: 0;
    }

    .preloader .spinner {
        --size: 100px;
        --first-block-clr: #f1f5f9;
        --second-block-clr: #bc943b;
        width: 100px;
        height: 100px;
        position: relative;
    }

    .preloader .spinner::after,
    .preloader .spinner::before {
        box-sizing: border-box;
        position: absolute;
        content: "";
        width: var(--size);
        height: var(--size);
        top: 50%;
        animation: up 2.4s cubic-bezier(0, 0, 0.24, 1.21) infinite;
        left: 50%;
        background: var(--first-block-clr);
    }

    .preloader .spinner::after {
        background: var(--second-block-clr);
        top: calc(50% - var(--size));
        left: calc(50% - var(--size));
        animation: down 2.4s cubic-bezier(0, 0, 0.24, 1.21) infinite;
    }

    @keyframes down {

        0%,
        100% {
            transform: none;
        }

        25% {
            transform: translateX(100%);
        }

        50% {
            transform: translateX(100%) translateY(100%);
        }

        75% {
            transform: translateY(100%);
        }
    }

    @keyframes up {

        0%,
        100% {
            transform: none;
        }

        25% {
            transform: translateX(-100%);
        }

        50% {
            transform: translateX(-100%) translateY(-100%);
        }

        75% {
            transform: translateY(-100%);
        }
    }


    .preloader .preloader h1 {
        font-size: 50px;
        color: #f1f5f9;
    }

    .preloader .message {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .preloader .message img {
        width: 300px;
    }


    /* CLASS TO SHOW PAGE */
    .preloader .show-page {
        transform: translateX(100%);
    }
</style>

<!-- PRELOADER -->
<div class="preloader">
    <div class="mb-5 spinner"></div>
    <div class="mt-5 message">
        <h1 class="text-center text-white">Almost there! Just a moment...</h1>
        <img src="{{asset('../images/logo/inspire-logo.png')}}" alt="" />
    </div>
</div>



<script>
    window.addEventListener("load", () => {
        setTimeout(() => {
          document.querySelector(".preloader").classList.add("fade-out");

          setTimeout(() => {
            document.querySelector(".preloader").style.display = "none";
          }, 500); 
        });
      });
</script>