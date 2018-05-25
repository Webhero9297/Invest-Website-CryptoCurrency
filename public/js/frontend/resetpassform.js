$(document).ready(function(){

    $('input[name="email"]').focus();

    doOnLoginForm();
});
function doOnSubmit() {
    var _pass = $('input[name="password"]').val();
    var _confirm_pass = $('input[name="confirm_password"]').val();
    if ( _pass != _confirm_pass ) {
        $('input[name="password"]').val('');
        $('input[name="confirm_password"]').val('');
        $('input[name="password"]').blur();
        $('input[name="confirm_password"]').blur();
        $('#myModal').modal('show');
    }
    else{
        $('form[class="auth-login"]').submit();
    }
}
doOnLoginForm = function(){
    //$('input[name="email"]').focus();
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