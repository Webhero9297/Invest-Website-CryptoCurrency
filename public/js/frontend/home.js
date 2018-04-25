var currentCryptoPage = 'prev';
var currentUsersPage = 'prev';
$(document).ready(function(){
    doOnLoginForm();
    doOnDrawCanvas();
    $('#top_cryptos_next').css('display', 'none');
    $('#top_users_next').css('display', 'none');

    loadLiveData();
    window.setInterval(loadLiveData, 10000);

    $('a[data-parent="#accordion"]').click(function(){
        if ( $(this).attr('aria-expanded') == undefined || $(this).attr('aria-expanded') == 'false' ){
            $('.collapse').collapse('hide');
            $(this).collapse("show");
        }

    });
    if ( alert_message != undefined ){
        notificationEx(alert_message);
    }


});
function loadLiveData() {
    $.get('/toplivedata', function(response){
        topUsers = response.top_users;
        topCryptos = response.topCryptos;

        drawTopUsers(topUsers);
        drawTopCryptos(topCryptos);
        if ( currentCryptoPage == 'prev' ){
            $('#top_cryptos_prev').css('display', '');
            $('#top_cryptos_next').css('display', 'none');
        }
        else{
            $('#top_cryptos_prev').css('display', 'none');
            $('#top_cryptos_next').css('display', '');
        }

        if ( currentUsersPage == 'prev' ) {
            $('#top_users_prev').css('display', '');
            $('#top_users_next').css('display', 'none');
        }
        else {
            if (top_users_count > 4) {
                $('#top_users_prev').css('display', 'none');
                $('#top_users_next').css('display', '');
            }
        }
    });
}
function drawTopUsers( topUsers ) {
    divHTML = '';
    if ( topUsers.length>0 ) {
        divHTML = '<div class="row" id="top_users_prev">';
        for( i=0; i<4; i++) {
            if ( topUsers[i] ) {
                user = topUsers[i];
                divHTML += '<div class="col-sm-3 div-avatar-panel" onclick="doOnGoUserPortfolio('+user.id+')">\
                                <div class="div-avatar-bg text-center">\
                                    <div class="div-numeric">'+(i+1)+'</div>';
                divHTML += '<div class="div-avatar-icon" style="width:90px;height:90px;margin-bottom:5px;">\
                                <img src="'+user.avatar+'" style="border-radius: 50%;">\
                                </div>\
                                <div class="div-user-name">'+user.full_name+'</div>\
                            </div>';
                divHTML += '<div class="div-white-wrap text-center">\
                                <div class="div-panel-icon-wrap">\
                                    <div class="div-panel-icon-wrap">\
                                        <img src="./assets/images/icon/top_portfolio_invested_capital.png" />\
                                    </div>\
                                </div>\
                                <div class="div-panel-title">INVESTED CAPITAL</div>\
                                <div class="div-panel-money">$'+user.invested_capital+'</div>\
                            </div>';
                divHTML += '<div class="div-white-wrap text-center">\
                                <div class="div-panel-icon-wrap">\
                                    <div class="div-panel-icon-wrap">\
                                    <img src="./assets/images/icon/top_portfolio_current_value.png" />\
                                    </div>\
                                    </div>\
                                    <div class="div-panel-title">CURRENT VALUE</div>\
                                <div class="div-panel-money">$'+user.current_value+'</div>\
                            </div>\
                            <div class="div-white-wrap text-center">\
                                <div class="div-panel-icon-wrap">\
                                <div class="div-panel-icon-wrap">\
                                <img src="./assets/images/icon/top_portfolio_profit_loss.png" />\
                                </div>\
                                </div>\
                                <div class="div-panel-title">PROFIT/ LOSS</div>\
                                <div class="div-panel-money">'+user.total_profit_loss_percentage+'%</div>\
                            </div>\
                            </div>';
            }
        }
        divHTML += '</div>';
        if ( topUsers.length>4 ) {
            divHTML += '<div class="row" id="top_users_next">';
            for( i=4; i<8; i++) {
                if ( topUsers[i] ) {
                    user = topUsers[i];
                    divHTML += '<div class="col-sm-3 div-avatar-panel" onclick="doOnGoUserPortfolio('+user.id+')">\
                                <div class="div-avatar-bg text-center">\
                                    <div class="div-numeric">'+(i+1)+'</div>';
                    divHTML += '<div class="div-avatar-icon" style="width:90px;height:90px;margin-bottom:5px;">\
                                <img src="'+user.avatar+'" style="border-radius: 50%;">\
                                </div>\
                                <div class="div-user-name">'+user.full_name+'</div>\
                            </div>';
                    divHTML += '<div class="div-white-wrap text-center">\
                                <div class="div-panel-icon-wrap">\
                                    <div class="div-panel-icon-wrap">\
                                        <img src="./assets/images/icon/top_portfolio_invested_capital.png" />\
                                    </div>\
                                </div>\
                                <div class="div-panel-title">INVESTED CAPITAL</div>\
                                <div class="div-panel-money">$'+user.invested_capital+'</div>\
                            </div>';
                    divHTML += '<div class="div-white-wrap text-center">\
                                <div class="div-panel-icon-wrap">\
                                    <div class="div-panel-icon-wrap">\
                                    <img src="./assets/images/icon/top_portfolio_current_value.png" />\
                                    </div>\
                                    </div>\
                                    <div class="div-panel-title">CURRENT VALUE</div>\
                                <div class="div-panel-money">$'+user.current_value+'</div>\
                            </div>\
                            <div class="div-white-wrap text-center">\
                                <div class="div-panel-icon-wrap">\
                                <div class="div-panel-icon-wrap">\
                                <img src="./assets/images/icon/top_portfolio_profit_loss.png" />\
                                </div>\
                                </div>\
                                <div class="div-panel-title">PROFIT/ LOSS</div>\
                                <div class="div-panel-money">'+user.total_profit_loss_percentage+'%</div>\
                            </div>\
                            </div>';
                }
            }
            divHTML += '</div>';
        }
    }
    $('#div_top_users_wrap').html(divHTML);
}
function drawTopCryptos(topCryptos) {
    divHTML = '<div class="row" id="top_cryptos_prev">';
    for( i=0; i<4; i++) {
        _crypto = topCryptos[i];
        divHTML += '<div class="col-sm-3 div-avatar-panel" onclick="doOnGoCoinDetailInfo(\''+_crypto.id+'\')">\
                        <div class="div-avatar-bg text-center">\
                            <div class="div-numeric">'+ (i+1) +'</div>';
        divHTML += '<div class="div-avatar-icon">\
                        <img src="https://files.coinmarketcap.com/static/widget/coins_legacy/64x64/'+_crypto.id+'.png" width="60px" height="60px" style="border-radius:50%;">\
                    </div>\
                    <div class="div-user-name">'+_crypto.name+'('+_crypto.symbol+')</div>\
                    <div class="div-user-name div-subtitle">'+_crypto.price_usd+' USD('+_crypto.percent_change_1h+'%)</div>\
                    </div>';
        divHTML += '<div class="div-white-wrap text-center">\
                        <div class="div-panel-icon-wrap">\
                            <img src="./assets/images/icon/top_crypto_rank.png" />\
                        </div>\
                        <div class="div-panel-title">RANK</div>\
                        <div class="div-panel-money">'+(i+1) +'</div>\
                    </div>\
                    <div class="div-white-wrap text-center">\
                        <div class="div-panel-icon-wrap">\
                            <img src="./assets/images/icon/top_crypto_market_cap.png" />\
                        </div>\
                        <div class="div-panel-title">MARKET CAP</div>\
                        <div class="div-panel-money">$'+_crypto.mkt_cap_usd+'</div>\
                    </div>\
                    <div class="div-white-wrap text-center">\
                        <div class="div-panel-icon-wrap">\
                        <img src="./assets/images/icon/top_crypto_24h.png" />\
                        </div>\
                        <div class="div-panel-title">VOLUME 24H</div>\
                    <div class="div-panel-money">$'+_crypto.h24_volume_usd+'</div>\
                    </div>\
                    </div>';
    }
    divHTML += '</div>';
    divHTML += '<div class="row" id="top_cryptos_next">';
    for( i=4; i<8; i++) {
        _crypto = topCryptos[i];
        divHTML += '<div class="col-sm-3 div-avatar-panel" onclick="doOnGoCoinDetailInfo(\''+_crypto.id+'\')">\
                        <div class="div-avatar-bg text-center">\
                            <div class="div-numeric">'+ (i+1) +'</div>';
        divHTML += '<div class="div-avatar-icon">\
                        <img src="https://files.coinmarketcap.com/static/widget/coins_legacy/64x64/'+_crypto.id+'.png" width="60px" height="60px" style="border-radius:50%;">\
                    </div>\
                    <div class="div-user-name">'+_crypto.name+'('+_crypto.symbol+')</div>\
                    <div class="div-user-name div-subtitle">'+_crypto.price_usd+' USD('+_crypto.percent_change_1h+'%)</div>\
                    </div>';
        divHTML += '<div class="div-white-wrap text-center">\
                        <div class="div-panel-icon-wrap">\
                            <img src="./assets/images/icon/top_crypto_rank.png" />\
                        </div>\
                        <div class="div-panel-title">RANK</div>\
                        <div class="div-panel-money">'+(i+1) +'</div>\
                    </div>\
                    <div class="div-white-wrap text-center">\
                        <div class="div-panel-icon-wrap">\
                            <img src="./assets/images/icon/top_crypto_market_cap.png" />\
                        </div>\
                        <div class="div-panel-title">MARKET CAP</div>\
                        <div class="div-panel-money">$'+_crypto.mkt_cap_usd+'</div>\
                    </div>\
                    <div class="div-white-wrap text-center">\
                        <div class="div-panel-icon-wrap">\
                        <img src="./assets/images/icon/top_crypto_24h.png" />\
                        </div>\
                        <div class="div-panel-title">VOLUME 24H</div>\
                    <div class="div-panel-money">$'+_crypto.h24_volume_usd+'</div>\
                    </div>\
                    </div>';
    }
    divHTML += '</div>';

    $('#div_coins_wrap').html(divHTML);
}

function doOnGoUserPortfolio(userId) {
    window.location.href=window.origin+'/detailportfolio/'+userId;
}
function doOnGoCoinDetailInfo(coinId) {
    window.location.href=window.origin+'/coinchart/'+coinId;
}
function doOnclick(stage) {
    if ( stage == 'prev' ) {
        $('#top_cryptos_prev').css('display', '');
        $('#top_cryptos_next').css('display', 'none');
        currentCryptoPage = 'prev';
    }
    else {
        $('#top_cryptos_prev').css('display', 'none');
        $('#top_cryptos_next').css('display', '');
        currentCryptoPage = 'next';
    }
}
function doOnTopUsersclick(stage) {
    if ( stage == 'prev' ) {
        $('#top_users_prev').css('display', '');
        $('#top_users_next').css('display', 'none');
        currentUsersPage = 'prev';
    }
    else {
        if (top_users_count > 4) {
            currentUsersPage = 'next';
            $('#top_users_prev').css('display', 'none');
            $('#top_users_next').css('display', '');
        }
    }
}
doOnDrawCanvas = function() {
    var mainCanvas = document.getElementById("myCanvas");
    var mainContext = mainCanvas.getContext('2d');
    var circles = new Array();
    var requestAnimationFrame = window.requestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.msRequestAnimationFrame;
    function Circle(radius, speed, width, xPos, yPos) {
        this.radius = radius;
        this.speed = speed;
        this.width = width;
        this.xPos = xPos;
        this.yPos = yPos;
        this.opacity = 0.9;
        this.counter = 0;
        var signHelper = Math.floor(Math.random() * 2);
        if (signHelper == 1) {
            this.sign = -1;
        } else {
            this.sign = 1;
        }
    }
    Circle.prototype.update = function () {
        this.counter += this.sign * this.speed;
        mainContext.beginPath();
        mainContext.arc(
            this.xPos + Math.cos(this.counter / 100) * this.radius,
            this.yPos + Math.sin(this.counter / 100) * this.radius,
            this.width,
            0,
            Math.PI * 2,
            false
        );
        mainContext.closePath();
        mainContext.fillStyle = 'rgba(255, 255, 255,' + this.opacity + ')';
        mainContext.fill();
    };
    function drawCircles() {
        var randomX = 400;
        var randomY = 400;
        for (var i = 0; i < 15; i++) {
            var speed = .1 + Math.random() * 0.1;
            var size = 7;
            var circle = new Circle(380, speed, size, randomX, randomY);
            circles.push(circle);
        }
        draw();
    }
    drawCircles();
    function draw() {
        mainContext.clearRect(0, 0, 800, 800);
        mainContext.beginPath();
        mainContext.arc(400,400,380,0,2*Math.PI);
        mainContext.stroke();
        mainContext.strokeStyle = '#FFFFFF33';
        mainContext.lineWidth = 3;
        for (var i = 0; i < circles.length; i++) {
            var myCircle = circles[i];
            myCircle.update();
        }
        requestAnimationFrame(draw);
    }

    Particles.init({
        selector: '#particles-js',
        color: '#888888',
        opacity: 0.1,
        maxParticles: 60,
        connectParticles: false,
        sizeVariations: 7,
        speed: 0.5
    });

    var particleCanvas = document.getElementById("particles-js");
    var particleContext = mainCanvas.getContext('2d');
    particleContext.fillStyle = 'rgba(255,255,255,0.3)';
    particleContext.lineWidth = 5;
    particleContext.save();
}
doOnLoginForm = function(){
    $('input.auth-input').blur(function() {
        var $this = $(this);
        if ($this.val())
            $this.addClass('used');
        else
            $this.removeClass('used');
    });

    var $ripples = $('.ripples');

    $ripples.on('click.Ripples', function(e) {

        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find('.ripplesCircle');

        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;

        $circle.css({
            top: y + 'px',
            left: x + 'px'
        });

        $this.addClass('is-active');

    });

    $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
        $(this).removeClass('is-active');
    });
}
doOnCircle = function() {
    window.addEventListener('load', eventWindowLoaded, false);
    function eventWindowLoaded() {
        canvasApp();
    }
    function canvasSupport () {
        return Modernizr.canvas;
    }
    function canvasApp() {
        if (!canvasSupport()) {
            return;
        }
        function  drawScreen () {
            context.fillStyle = '#EEEEEE00';
            context.fillRect(0, 0, theCanvas.width, theCanvas.height);
            ball.x = circle.centerX + Math.cos(circle.angle) * circle.radius;
            ball.y = circle.centerY + Math.sin(circle.angle) * circle.radius;
            circle.angle += ball.speed;
            context.fillStyle = "#EEEEEE";
            context.beginPath();
            context.arc(ball.x,ball.y,15,0,Math.PI*2,true);
            context.closePath();
            context.fill();
        }
        var radius = 100;
        var circle = {centerX:250, centerY:250, radius:125, angle:0}
        var ball = {x:0, y:0,speed:.01};
        theCanvas = document.getElementById("canvasOne");
        context = theCanvas.getContext("2d");
        setInterval(drawScreen, 33);
    }
}
doOnParticles = function() {
    let resizeReset = function() {
        w = canvasBody.width = window.innerWidth;
        h = canvasBody.height = window.innerHeight;
    }

    const opts = {
        particleColor: "rgb(0,78,125)",
        lineColor: "rgb(0,78,125)",
        particleAmount: 10,
        defaultSpeed: 1,
        variantSpeed: 1,
        defaultRadius: 16,
        variantRadius: 19,
        linkRadius: 1200,
    };

    window.addEventListener("resize", function(){
        deBouncer();
    });

    let deBouncer = function() {
        clearTimeout(tid);
        tid = setTimeout(function() {
            resizeReset();
        }, delay);
    };

    let checkDistance = function(x1, y1, x2, y2){
        return Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
    };

    let linkPoints = function(point1, hubs){
        for (let i = 0; i < hubs.length; i++) {
            let distance = checkDistance(point1.x, point1.y, hubs[i].x, hubs[i].y);
            let opacity = 1 - distance / opts.linkRadius;
            if (opacity > 0) {
                drawArea.lineWidth = 4.5;
                drawArea.strokeStyle = `rgba(${rgb[0]}, ${rgb[1]}, ${rgb[2]}, ${opacity})`;
                drawArea.beginPath();
                drawArea.moveTo(point1.x, point1.y);
                drawArea.lineTo(hubs[i].x, hubs[i].y);
                drawArea.closePath();
                drawArea.stroke();
            }
        }
    }

    Particle = function(xPos, yPos){
        this.x = Math.random() * w;
        this.y = Math.random() * h;
        this.speed = opts.defaultSpeed + Math.random() * opts.variantSpeed;
        this.directionAngle = Math.floor(Math.random() * 360);
        this.color = opts.particleColor;
        this.radius = opts.defaultRadius + Math.random() * opts. variantRadius;
        this.vector = {
            x: Math.cos(this.directionAngle) * this.speed,
            y: Math.sin(this.directionAngle) * this.speed
        };
        this.update = function(){
            this.border();
            this.x += this.vector.x;
            this.y += this.vector.y;
        };
        this.border = function(){
            if (this.x >= w || this.x <= 0) {
                this.vector.x *= -1;
            }
            if (this.y >= h || this.y <= 0) {
                this.vector.y *= -1;
            }
            if (this.x > w) this.x = w;
            if (this.y > h) this.y = h;
            if (this.x < 0) this.x = 0;
            if (this.y < 0) this.y = 0;
        };
        this.draw = function(){
            drawArea.beginPath();
            drawArea.arc(this.x, this.y, this.radius, 0, Math.PI*2);
            drawArea.closePath();
            drawArea.fillStyle = this.color;
            drawArea.fill();
        };
    };

    function setup(){
        particles = [];
        resizeReset();
        for (let i = 0; i < opts.particleAmount; i++){
            particles.push( new Particle() );
        }
        window.requestAnimationFrame(loop);
    }

    function loop(){
        window.requestAnimationFrame(loop);
        drawArea.clearRect(0,0,w,h);
        for (let i = 0; i < particles.length; i++){
            particles[i].update();
            particles[i].draw();
        }
        for (let i = 0; i < particles.length; i++){
            linkPoints(particles[i], particles);
        }
    }
    const canvasBody = document.getElementById("canvas"),
        drawArea = canvasBody.getContext("2d");
    let delay = 200, tid,
        rgb = opts.lineColor.match(/\d+/g);
    resizeReset();
    setup();
}

function notificationEx(alert_message) {
    //message = '<br/><img src="'+logo_img+'" height="50px" />';
    message = '<label class="message" style="width:100%;word-wrap: break-word;">&nbsp;&nbsp;'+alert_message+'</label>&nbsp;&nbsp;&nbsp;';
    $.notify({
        title: '<img src="'+logo_img+'" height="30px" />', //'<label class="message alert-title">Moonfolio!</label>',
        icon: '',
        message: message
    }, {
        type: 'danger',
        animate: {
            enter: 'animated fadeInUp',
            exit: 'animated fadeOutRight'
        },
        placement: {
            from: "bottom",
            align: "left"
        },
        offset: 20,
        spacing: 10,
//        showProgressbar: true,
        z_index: 1031,
        delay: 60000,
        timer: 100,
        onShow: function(){
            x.play();
        }
    });
}