<div id="footer" class="bg-black">
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="pull-left" src="{{ asset('assets/img/Alberta POS_Logo.png') }}">
                </div>
                <div class="col-md-8  text-justify padding">
                    ©2016-2017 Alberta Inc. All Rights Reserved. This site contains confidential and proprietary information of Alberta Inc. You may not disclose, copy or use any part of the information or materials on this site for any purpose in any medium without the express written consent of Alberta Inc. All trademarks, service marks, and trade names referenced in this material are the property of their respective owners.
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<style type="text/css">
input[name="email"], input[name="password"]{
    z-index:0 !important;
}
#footer {
    position: fixed;
    color: #ccc;
    display: block;
    vertical-align: bottom;
    background-color: #222222 !important;
    font-size: 14px;
    margin-bottom: 0px;
    width: 100%;
    bottom: 0px;
}
#footer .copyright {
    background-color: #222222 !important;
    vertical-align: top !important;
    padding: 4px;
    -webkit-box-shadow: 0px -2px 2px 0px rgba(50, 50, 50, 0.75);
    -moz-box-shadow: 0px -2px 2px 0px rgba(50, 50, 50, 0.75);
    box-shadow: 0px -2px 2px 0px rgba(50, 50, 50, 0.75);
}
img {
    max-width: 55% !important;
}
img {
    vertical-align: middle;
}
img {
    border: 0;
}
.padding {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media only screen and (max-width: 767px) {
    .padding{
        clear: both;
    }

    img {
        max-width: 55% !important;
    }
}

@media only screen and (max-width: 1024px) {
    img {
        max-width: 25% !important;
    }
}
</style>
</html>