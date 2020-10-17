<style scoped>
    .recent-trending-banner{
        /*height: 29em;*/
        width: 100%;
        padding: 0 6.3em;
        background-image: url("https://res.cloudinary.com/indianpac/image/upload/naf/images/pattern.jpg");
    }
    .owl-carousel-trending{
        height: 100%;
        padding: 3.3em 0;
    }
    .owl-carousel-trending .owl-item img{
        /*height:22em;*/
		/*object-fit:cover;*/
    }
    .owl-carousel-trending .owl-nav button.owl-next > span,
    .owl-carousel-trending .owl-nav button.owl-prev > span{
        display:none;
    }
    .owl-carousel-trending .owl-nav button.owl-next,
    .owl-carousel-trending .owl-nav button.owl-prev{
        height: 4em;
        width: 2em;
        position: absolute;
        top: 11rem;
        outline: none;

    }
    .owl-carousel-trending .owl-dot{
        outline:none;
    }
    .owl-carousel-trending.owl-theme > .owl-dots{
        position: relative;
        top: 1em;
        display: none;
    }
    .owl-carousel-trending.owl-theme > .owl-dots .owl-dot{
        zoom:0.8;
    }
    .owl-carousel-trending.owl-theme > .owl-dots .owl-dot span{
        background: #969696;
        box-shadow: inset 1px 1px 3px black;
    }
    .owl-carousel-trending.owl-theme > .owl-dots .owl-dot.active span,
    .owl-carousel-trending.owl-theme > .owl-dots .owl-dot:hover span{
        background: #FEFEFE;
        box-shadow: inset 1px 1px 3px black;
    }
    .owl-carousel-trending .owl-nav button.owl-next{
        background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/banner_arrows_nxt.png);
        background-repeat: no-repeat;
        background-size: contain;
        right: -4rem;

    }
    .owl-carousel-trending.owl-theme > .owl-nav > button.owl-next:hover{
        background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/banner_arrows_nxt.png);
        background-repeat: no-repeat;
        background-size: contain;
    }
    .owl-carousel-trending .owl-nav button.owl-prev{
        background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/banner_arrows_prev.png);
        background-repeat: no-repeat;
        background-size: contain;
        left: -3em;
    }
    .owl-carousel-trending.owl-theme > .owl-nav > button.owl-prev:hover{
        background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/banner_arrows_prev.png);
        background-repeat: no-repeat;
        background-size: contain;
    }
    /* Styling Pagination*/
    .owl-carousel-trending .owl-controls .owl-page {
        display: inline-block;
    }
    .owl-carousel-trending .owl-controls .owl-page span {
        background: none repeat scroll 0 0 #869791;
        border-radius: 20px;
        display: block;
        height: 12px;
        margin: 5px 7px;
        opacity: 0.5;
        width: 12px;
    }
    .trending-banner-wrapper{
        position:relative;
    }
    .trending-image-content{
        position: absolute;
        width: 100%;
        height: 47px;
        border-top: 1px solid transparent;
        bottom: 0;
        background: #ffffff78;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        font-style: italic;
        font-weight: 600;
        font-size: 18px;
        color: #020204;
    }
    @media(max-width:768px){
        .owl-carousel-trending{padding: 2.3em 0;}
        .recent-trending-banner {
            padding: 0 1.7em;
            /*height: 22.5em;*/
        }
        .owl-carousel-trending.owl-theme > .owl-dots {
            display: none;
        }
        .owl-carousel-trending .owl-item img {
            /*height: 18em;*/
        }
    }
    @media (min-width: 769px) and (max-width:1024px){


    }
    @media (min-width: 1025px) and (max-width:1440px){
        .recent-trending-banner {
            /*height: 25em;*/
        }
        .owl-carousel-trending .owl-item img {
            /*height: 19em;*/
        }
        .owl-carousel-trending .owl-nav button.owl-next, .owl-carousel-trending .owl-nav button.owl-prev {
            top: 9rem;
        }
    }
</style>
<div class="recent-trending-banner">
    <div class="owl-carousel-trending owl-theme">
    </div>
</div>