/* VanillaJS v0.4  by bronco@warriordudimanche.net */
	// fonctions systeme ----------------------------------------------------
	function when_ready(funct){document.addEventListener("DOMContentLoaded",funct,false);}
	function _(obj,single){
		if (typeof obj=='string'){
			if (single){return first(obj);}
			else{return all(obj);}
		}else{
			if (single && obj[0]){return obj[0];}
		}
		return obj;
	}
	function _tcl(el,cl){
		if (el.classList) {
		    el.classList.toggle(cl)
		} else {
		    var classes = el.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0)
		      classes.splice(existingIndex, 1)
		    else
		      classes.push(cl);
		    el.className = classes.join(' ')
		}
	}
	function _acl(el,cl){
		if (el.classList){ el.classList.add(cl);}
		else {el.className += ' ' + cl; }
	}
	function _rcl(el,cl){
		if (el.classList)
		  el.classList.remove(cl)
		else
		  el.className = el.className.replace(new RegExp('(^| )' + cl.split(' ').join('|') + '( |$)', 'gi'), ' ')
	}
	function _adev(obj,ev,funct){if (obj.addEventListener){obj.addEventListener(ev, funct);}}
	function _tglval(valToTgl,val1,val2){if (valToTgl==val1){return val2;}else{return val1;}}
	

	// parcours du DOM ----------------------------------------------------
	function all(tag){return document.querySelectorAll(tag);}
	function first(tag){return document.querySelector(tag);}
	function allIn(obj,selector){
		obj=_(obj,1);if (!obj){return false}
		return obj.querySelectorAll(selector);
	}
	function firstIn(obj,selector){
		obj=_(obj,1);if (!obj){return false}
		if (selector) {return obj.querySelector(selector);}else{return obj.children[0];}
	}
	function lastIn(obj,selector){
		if (typeof obj=='string'){obj=first(obj);}
		if (!obj){return false}
		if (selector) {
			childs=obj.querySelectorAll(selector);
			if (!childs){return false;}
			if (!childs.length){return childs;}
			return childs[childs.length-1];
		}else{return obj.lastElementChild;}
	}
	function parent(obj,degree){
		obj=_(obj,1);if (!obj){return false}
		if (!degree||degree==1){return obj.parentNode;}
		else{
			for (i=1;i<=degree;i++){
				obj=obj.parentNode;
			}
			return obj;
		}

	}
	function next(obj){
		obj=_(obj,1);if (!obj){return false}
		return obj.nextElementSibling;
	}
	function previous(obj){
		obj=_(obj,1);if (!obj){return false}
		return obj.previousElementSibling;
	}



	// contenu ----------------------------------------------------
	function remove(obj){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.parentNode.removeChild(obj);return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.parentNode.removeChild(el);});
		}
	}
	function prepend(obj,content,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.innerHTML=content+obj.innerHTML;return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.innerHTML=content+el.innerHTML;});
		}
		if (callback) {callback();}  
	}
	function append(obj,content,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.innerHTML+=content;return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.innerHTML+=content;});
		}
		if (callback) {callback();}  
	}
	function before(obj, content,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.insertAdjacentHTML('beforebegin', content);return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.insertAdjacentHTML('beforebegin', content);});
		}
		if (callback) {callback();}  	
	}
	function after(obj, content,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.insertAdjacentHTML('afterend', content);return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.insertAdjacentHTML('afterend', content);});
		}
		if (callback) {callback();}  		
	}
	function clear(obj,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.innerHTML='';return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.innerHTML='';});
		}
		if (callback) {callback();}  
	}
	
	function form2json( form ) { // not mine (https://codepen.io/gabrieleromanato/pen/LpLVeQ)
		var obj = {};
		form=_(form,1);
		var elements = form.querySelectorAll( "input, select, textarea" );
		for( var i = 0; i < elements.length; ++i ) {
			var element = elements[i];
			var name = element.name;
			var value = element.value;

			if( name ) {
				obj[ name ] = value;
			}
		}

		return JSON.stringify( obj );
	}

	// Ajax ----------------------------------------------------
	function ajax(url,data,method,target,callback){
		if (!target){target ='';}
		if (!method){method='GET';}
		if (!data){data='';}			
		// Envoi de la requête
		request = new XMLHttpRequest;
		request.open(method, url, true);
		if (method=='POST'){request.setRequestHeader("Content-type","application/x-www-form-urlencoded");}
		request.send(data);

		// Gestion de la réponse du serveur
		request.onreadystatechange=function(){
			if (request.readyState==4 && request.status==200){
				rep=request.responseText;
				if (target){
					if (typeof target=='string'){target=all(target);}
					if (!target.length){target.innerHTML=rep;return true;}
					if (target.length){	[].forEach.call(target, function(el) {el.innerHTML=rep;}); }
				}else{return rep;}

			}
		}
		if (callback) {callback();}  
	}
	function onProgress(e) {
	  var percentComplete = (e.position / e.totalSize)*100;
		return percentComplete;
	}

	get = async function(url,data){	
		return new Promise(function(resolve,reject){
			request = new XMLHttpRequest();
			request.onreadystatechange=function(){
				if (request.readyState==4){
					if (request.status==200){
						resolve(request.responseText);
					}else{
						reject(request);
					}
				}
			}
			request.open('GET', url, true);
			request.send(data);
		});					
	}
	post = async function(url,data){
		return new Promise(function(resolve,reject){
			request = new XMLHttpRequest();
			request.onreadystatechange=function(){
				if (request.readyState==4){
					if (request.status==200){
						resolve(request.responseText);
					}else{
						reject(request);
					}
				}
			}
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);
		});		
	}

	// Classes ----------------------------------------------------
	function addClass(obj,classname,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){
			_acl(obj,classname);
			if (callback){callback();}
			return true;			
		}
		if (obj.length){
			[].forEach.call(obj, function(el) {_acl(el,classname);});
			if (callback){callback();}
		}
		 
	}
	function removeClass(obj,classname,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){_rcl(obj,classname);return true;}
		if (obj.length){
			[].forEach.call(obj, function(el) {_rcl(el,classname);});
		}
		if (callback) {callback();}  
	}
	function toggleClass(obj,classname,callback){
		obj=_(obj);if (!obj||obj.length==0){return false}
		if (!obj.length){_tcl(obj,classname);}
		if (obj.length){
			[].forEach.call(obj, function(el) {_tcl(el,classname)});
		}
		if (callback){callback();}  
	}
	function hasClass(obj,classname,callback){
		obj=_(obj,1);if (!obj){return false}
		return obj.className && new RegExp("(\\s|^)" + classname + "(\\s|$)").test(obj.className);
	}

	// visibilité ----------------------------------------------------
	function show(obj,type){
		obj=_(obj);if (!obj){return false}
		if (typeof type === 'undefined'){type='block';}
		if (!obj.length){obj.style.display =type;}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.style.display =type;});
		}
		
	}
	function hide(obj){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.style.display ='none';}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.style.display ='none';});
		}
	}
	function toggle(obj,callback){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){obj.style.display=_tglval(obj.style.display, 'none' ,'');}
		if (obj.length){
			[].forEach.call(obj, function(el) {el.style.display=_tglval(el.style.display, 'none' ,'');});
		}
		if (callback) {callback();}  
	}
	function fadeTo(obj,opacity,callback){return style(obj,'opacity:'+opacity+';');}


	// attributs ----------------------------------------------------
	function attr(obj,attr,value){
		obj=_(obj);if (!obj){return false}
		if (!obj.length){
			if (value){obj.setAttribute(attr,value);}
			else{
				if (obj.getAttribute){return obj.getAttribute(attr);}
				else{return false;}
			}
		}
		if (obj.length){
			if (value){
				[].forEach.call(obj, function(el) {el.setAttribute(attr,value);});
			}else{return obj[0].getAttribute(attr);}
		}
	}
	function removeAttr(obj,attr){
		obj=_(obj);if (!obj){return false}

		if (!obj.length){
			obj.removeAttribute(attr);
		}
		else{
			[].forEach.call(obj, function(el) {el.removeAttribute(attr);});
		}
	}
	function style(obj,css,callback){return attr(obj,'style',css);  }
	function id(obj){return attr(obj,'id');}
	function href(obj){return attr(obj,'href');}

	// Evènement ----------------------------------------------------
	function on(ev,obj,funct){	
		obj=_(obj);
		if (!obj){obj=window.document;}
		if (!obj[0]){_adev(obj,ev,funct);}
		else{[].forEach.call(obj, function(el) {_adev(el,ev,funct);});}
		 
	}
	function onDomChange(funct,callback){on("DOMSubtreeModified",'',funct);if (callback) {callback();}  }	
	
	// divers ----------------------------------------------------
	function isInViewport(obj) {
		obj=_(obj,1);if (!obj){return false}
		var rect = obj.getBoundingClientRect();
		var html = document.documentElement;
		return (
		rect.top >= 0 &&
		rect.left >= 0 &&
		rect.bottom <= (window.innerHeight || html.clientHeight) &&
		rect.right <= (window.innerWidth || html.clientWidth)
		);
	}
	function each(obj,funct,callback){
		obj=_(obj);if (!obj){return false}
		if (obj.length){Array.prototype.forEach.call(obj,funct);}
		if (callback) {callback();}  
	}
	function numVal(obj){
		obj=_(obj,1);if (!obj){return false}
		if (val=attr(obj,"value")){return parseInt(val);}else{return parseInt(obj.innerHTML);}
	}
	function value(obj,value){
		obj=_(obj,1);if (!obj){return false}
		if (typeof value!=="undefined"){
			obj.value=value;
		}else{
			val=obj.value;
			if (val){return val;}else{return obj.innerHTML;}
		}
		
	}

function refresh(){location.reload();}



