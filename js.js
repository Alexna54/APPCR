 Ajax = function (url) {
     this.query = function (params) {
         var data = '';//'q='+encodeURIComponent(q);
         for (key in params)
             data += key+'='+encodeURIComponent(params[key])+'&';
         ajax.setRequestHeader('Content-length', data.length );
         ajax.send(data);
     }
     
     this.setCallback200 = function (cb) {
         _callback200 = cb;
     }
     
     /* CONSTRUCTOR */
     
     var _callback200 = null;
     
     var ajax = null;
     try { // Firefox, Opera 8.0+, Safari
         ajax = new XMLHttpRequest();
     } catch (e) { // Puto y pestilente Internet Explorer
         try {
             ajax = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
             ajax = new ActiveXObject("Microsoft.XMLHTTP");
         }
     }
 
     ajax.open('POST', url, true);
     ajax.setRequestHeader('Connection', 'close');
     ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
     ajax.onreadystatechange = function () {
         if (ajax.readyState == 4) {
             if (ajax.status == 200) {
                 if (_callback200!=null)
                     _callback200(ajax.responseText);
             }
         }
     }
 }
 
 
 var page = 0;
 
 function load_more() {
     page++;
 
     var w = window.innerWidth;
 
     var ajax = new Ajax('/cr/ajax/load_more.php');
     ajax.setCallback200(function(text){
         var json = eval('('+text+')');
         var imagenes = document.getElementById('imagenes');
         for (k in json) {
             var img = document.createElement('img');
             img.src = '/cr/ajax/img/?id='+json[k]+'&w='+w;
             imagenes.appendChild(img);
         }
     });
     ajax.query({'p':page});
 }
 
 load_more();
 
