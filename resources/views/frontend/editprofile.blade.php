@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
    }
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    /***********************   Country List AutoComplete   Start  *****************************/
    .autocomplete-items {
        position: absolute;
        border: 1px solid #4c4c4c;
        /*border-bottom: none;*/
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
        max-height: 300px;
        overflow-y: auto;
    }
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #010101;
        border-bottom: 1px solid #101010;
    }
    .autocomplete-items div:hover {
        /*when hovering an item:*/
        background-color: #5a5a5a;
    }
    .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    .box:hover{box-shadow:5px 2px 100px 1px grey;}

    @media only screen and (max-width:768px)
    {
        .box{width:100%;}
    }
    /***********************   Country List AutoComplete    End   *****************************/

    /***************************************  Custom select box start  *********************************************/
    @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    /*@import url(font-icomoon.css);*/
    @import url(https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css);
    /** Custom field plugin **/
    /* SELECT */
    .selectCF{
        margin:0;
        padding:0;
        display:block;
        position:relative;
        font-family: Montserrat-light;
        font-size:17px;
        font-weight:bold;
        z-index:1000;
        margin-top: -11px;
    }
    .selectCF li{
        list-style:none;
        cursor: pointer;
        perspective: 900px;
        -webkit-perspective: 900px;
        text-align: left;
    }
    .selectCF > li{
        position:relative;
        font-size:0;
    }
    .selectCF span{
        display:inline-block;
        height:45px;
        line-height:45px;
        color:#FFF;
        z-index:1;
    }
    .selectCF .arrowCF{
        transition: .3s;
        -webkit-transition: .3s;
        width:45px;
        text-align:center;
        vertical-align: top;
        font-size:17px;
        border: 1px solid #FFFFFF55;
    }
    .selectCF .titleCF{
        padding: 0 10px 0 20px;
        font-size:16px;
        font-family: Montserrat-light;
        font-weight:400;
        overflow:hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid #FFFFFF55;
    }
    .selectCF .searchCF{
        padding: 0 10px 0 20px;
        border-left: dotted 1px #434343;
        /*border-left: dotted 1px #0297bf;*/
        position: absolute;
        top:0;
        right:0;
        z-index:-1;
    }
    @keyframes searchActive {
        from{ transform: rotateY(180deg) }
        to{ transform: rotateY(0deg); }
    }@-moz-keyframes searchActive {
         from{ transform: rotateY(180deg) }
         to{ transform: rotateY(0deg); }
     }
    @-webkit-keyframes searchActive {
        from{ -webkit-transform: rotateY(180deg) }
        to{ -webkit-transform: rotateY(0deg); }
    }
    .searchActive .searchCF{
        z-index:1;
        animation: searchActive 0.3s alternate 1;
        -moz-animation: searchActive 0.3s alternate 1;
        -webkit-animation: searchActive 0.3s alternate 1;
    }
    .searchActive .titleCF{
        opacity:0;
    }
    .selectCF .searchCF input{
        font-family: 'Neucha', cursive;
        line-height:45px;
        border:none;
        padding:0;
        margin:0;
        width:100%;
        height:100%;
        background:transparent;
        font-size:17px;
    }
    .selectCF .searchCF input:active, .selectCF .searchCF input:focus{
        box-shadow:none;
        border:none;
        outline: none;
    }
    .selectCF li ul{
        display:none;
        position:absolute;
        top:100%;
        left:0;
        padding: 0 !important;
        width:100%;
        max-height: 255px;
        overflow-y: auto;
        transition: .2s;
        -webkit-transition: .2s;
        z-index:2;
        background: #0297bf00;
        border: 1px solid #ced4da;

    }
    .selectCF li ul li{
        padding:9px 0 9px 20px;
        border-bottom: 1px solid rgba(240,240,240,.9);
        font-weight:normal;
        font-size:14px;
        transition: .2s;
        -webkit-transition: .2s;
        overflow:hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .selectCF li ul li:hover{
        background: #111111;
        color:#FFF;
    }
    .selectCF .selected{
        background: #0297bf;
        /*border-bottom: solid 1px #bf3259;*/
        color:#FFF;
    }
    .selectCF li ul li:last-child{
        border-bottom: none;
    }
    .onCF .arrowCF{
        transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
    @-moz-keyframes effect1 {
        from{ transform: translateY(15px); opacity:0; }
        to{ transform: translateY(0px); opacity:1; }
    }
    @-webkit-keyframes effect1 {
        from{ -webkit-transform: translateY(15px); opacity:0; }
        to{ -webkit-transform: translateY(0px); opacity:1; }
    }
    .onCF li ul{
        display:block;
        -moz-animation: effect1 0.3s alternate 1;
        -webkit-animation: effect1 0.3s alternate 1;
    }

    .selected {
        background: #0297bf;
        border: 0!important;
        box-shadow: 0!important;
    }
    /***************************************  Custom select box end    *********************************************/
</style>
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container" style="padding-bottom: 278px;">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    Personal Information
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('save.details') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="full_name">Full Name</label>
                                <input type="text" class="form-control input-form-control grey-border grey-color" style="text-transform: capitalize;" tabindex="1" id="full_name" name="full_name" value="{{ $full_name }}" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" class="form-control input-form-control grey-border grey-color" tabindex="2" id="email" name="email" value="{{ $email }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label class="control-label" for="gender">Gender</label>
                                <select name="gender" class="select" tabindex="3">
                                    @if ( $gender == 0 )
                                        <option value="0" selected>Male</option>
                                        <option value="1">Female</option>
                                    @else
                                        <option value="0">Male</option>
                                        <option value="1" selected>Female</option>
                                    @endif
                                </select>
                                {{--<select name="gender" class="form-control our" tabindex="3">--}}
                                    {{--@if ( $gender == 0 )--}}
                                        {{--<option value="0" selected>Male</option>--}}
                                        {{--<option value="1">Female</option>--}}
                                    {{--@else--}}
                                        {{--<option value="0">Male</option>--}}
                                        {{--<option value="1" selected>Female</option>--}}
                                    {{--@endif--}}

                                {{--</select>--}}
                            </div>
                            <div class="form-group col-sm-2">
                                <label class="control-label" for="age">Age</label>
                                <div class="input-group spinner">
                                    <input type="text" class="form-control input-form-control grey-border grey-color" tabindex="4" id="age" name="age" style="font-size:24px;" value="{{ $age }}">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="email">Country</label>
                                {{--<input type="text" class="form-control input-form-control grey-border grey-color" tabindex="5" id="country" name="country" value="{{ $country }}">--}}
                                <div class="input-group autocomplete" style="width:100%;">
                                    <input id="NaCountry" type="Country" class="form-control input-form-control grey-border grey-color" name="country" value="{{ $country }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="group text-right">
                            <button type="submit" class="button buttonBlue btn-save-details">SAVE DETAILS
                                <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                            </button>
                            <a href="{{ route('profile') }}" class="button buttonRed btn-save-details ui-corner-all">CANCEL</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<script>
    function autocomplete(inp, arr) {
        var currentFocus;
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) { //up
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }
    var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
    autocomplete(document.getElementById("NaCountry"), countries);
</script>
<script src="{{ asset('./js/frontend/editprofile.js') }}"></script>
@endsection
