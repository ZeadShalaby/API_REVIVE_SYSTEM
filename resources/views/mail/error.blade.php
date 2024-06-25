<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>


<body
    style="
      @import url('https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700,800');
      * {
        box-sizing: border-box;
      }
    ">
    <div class="blog-slider"
        style="
        width: 85%;
        padding: 15px 35px;
        max-width: 700px;
        background: #fff;
        box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
        border-radius: 25px;
        height: 700px;
        transition: all 0.3s;
      ">
        <div class="blog-slider__img">
            <img src="https://imgur.com/qXkcg9N.png" alt="" style="width: 40%" />
        </div>
        <span class="blog-slider__code"
            style="
          color: #7b7992;
          margin-bottom: 15px;
          display: block;
          font-weight: 500;
        ">
            <h3>📫</h3>{{ $error['date'] }}
        </span>
        <div class="blog-slider__title"
            style="
          font-size: 24px;
          font-weight: 700;
          color: #0d0925;
          margin-bottom: 20px;
        ">
            Lorem Ipsum Dolor
        </div>
        <div class="blog-slider__text" style="color: #4e4a67; margin-bottom: 30px; line-height: 1.5em">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae
            voluptate repellendus magni illo ea animi?
        </div>
        <a href="#" class="blog-slider__button"
            style="
          display: inline-flex;
          background-image: linear-gradient(147deg, #fe8a39 0%, #fd3838 74%);
          padding: 15px 35px;
          border-radius: 50px;
          color: #fff;
          box-shadow: 0px 14px 80px rgba(252, 56, 56, 0.4);
          text-decoration: none;
          font-weight: 500;
          justify-content: center;
          text-align: center;
          letter-spacing: 1px;
        ">READ
            MORE</a>
    </div>
</body>
