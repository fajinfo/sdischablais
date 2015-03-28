!function(){function b(a){var d=b.modules[a];if(!d){throw new Error('failed to require "'+a+'"')}return"exports" in d||"function"!=typeof d.definition||(d.client=d.component=!0,d.definition.call(this,d.exports={},d),delete d.definition),d.exports}b.modules={},b.register=function(a,d){b.modules[a]={definition:d}},b.define=function(a,d){b.modules[a]={exports:d}},b.register("component~emitter@1.1.2",function(f,e){function h(c){return c?g(c):void 0}function g(d){for(var c in h.prototype){d[c]=h.prototype[c]}return d}e.exports=h,h.prototype.on=h.prototype.addEventListener=function(d,c){return this._callbacks=this._callbacks||{},(this._callbacks[d]=this._callbacks[d]||[]).push(c),this},h.prototype.once=function(j,i){function l(){k.off(j,l),i.apply(this,arguments)}var k=this;return this._callbacks=this._callbacks||{},l.fn=i,this.on(j,l),this},h.prototype.off=h.prototype.removeListener=h.prototype.removeAllListeners=h.prototype.removeEventListener=function(j,i){if(this._callbacks=this._callbacks||{},0==arguments.length){return this._callbacks={},this}var m=this._callbacks[j];if(!m){return this}if(1==arguments.length){return delete this._callbacks[j],this}for(var l,k=0;k<m.length;k++){if(l=m[k],l===i||l.fn===i){m.splice(k,1);break}}return this},h.prototype.emit=function(j){this._callbacks=this._callbacks||{};var i=[].slice.call(arguments,1),m=this._callbacks[j];if(m){m=m.slice(0);for(var l=0,k=m.length;k>l;++l){m[l].apply(this,i)}}return this},h.prototype.listeners=function(c){return this._callbacks=this._callbacks||{},this._callbacks[c]||[]},h.prototype.hasListeners=function(c){return !!this.listeners(c).length}}),b.register("dropzone",function(a,d){d.exports=b("dropzone/lib/dropzone.js")}),b.register("dropzone/lib/dropzone.js",function(a,d){(function(){var w,v,u,t,s,r,q,p,o={}.hasOwnProperty,n=function(f,e){function h(){this.constructor=f}for(var g in e){o.call(e,g)&&(f[g]=e[g])}return h.prototype=e.prototype,f.prototype=new h,f.__super__=e.prototype,f},c=[].slice;v="undefined"!=typeof Emitter&&null!==Emitter?Emitter:b("component~emitter@1.1.2"),q=function(){},w=function(f){function e(h,l){var k,j,i;if(this.element=h,this.version=e.version,this.defaultOptions.previewTemplate=this.defaultOptions.previewTemplate.replace(/\n*/g,""),this.clickableElements=[],this.listeners=[],this.files=[],"string"==typeof this.element&&(this.element=document.querySelector(this.element)),!this.element||null==this.element.nodeType){throw new Error("Invalid dropzone element.")}if(this.element.dropzone){throw new Error("Dropzone already attached.")}if(e.instances.push(this),this.element.dropzone=this,k=null!=(i=e.optionsForElement(this.element))?i:{},this.options=g({},this.defaultOptions,k,null!=l?l:{}),this.options.forceFallback||!e.isBrowserSupported()){return this.options.fallback.call(this)}if(null==this.options.url&&(this.options.url=this.element.getAttribute("action")),!this.options.url){throw new Error("No URL provided.")}if(this.options.acceptedFiles&&this.options.acceptedMimeTypes){throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.")}this.options.acceptedMimeTypes&&(this.options.acceptedFiles=this.options.acceptedMimeTypes,delete this.options.acceptedMimeTypes),this.options.method=this.options.method.toUpperCase(),(j=this.getExistingFallback())&&j.parentNode&&j.parentNode.removeChild(j),this.options.previewsContainer!==!1&&(this.previewsContainer=this.options.previewsContainer?e.getElement(this.options.previewsContainer,"previewsContainer"):this.element),this.options.clickable&&(this.clickableElements=this.options.clickable===!0?[this.element]:e.getElements(this.options.clickable,"clickable")),this.init()}var g;return n(e,f),e.prototype.events=["drop","dragstart","dragend","dragenter","dragover","dragleave","addedfile","removedfile","thumbnail","error","errormultiple","processing","processingmultiple","uploadprogress","totaluploadprogress","sending","sendingmultiple","success","successmultiple","canceled","canceledmultiple","complete","completemultiple","reset","maxfilesexceeded","maxfilesreached"],e.prototype.defaultOptions={url:null,method:"post",withCredentials:!1,parallelUploads:2,uploadMultiple:!1,maxFilesize:256,paramName:"file",createImageThumbnails:!0,maxThumbnailFilesize:10,thumbnailWidth:100,thumbnailHeight:100,maxFiles:null,params:{},clickable:!0,ignoreHiddenFiles:!0,acceptedFiles:null,acceptedMimeTypes:null,autoProcessQueue:!0,autoQueue:!0,addRemoveLinks:!1,previewsContainer:null,dictDefaultMessage:"Drop files here to upload",dictFallbackMessage:"Your browser does not support drag'n'drop file uploads.",dictFallbackText:"Please use the fallback form below to upload your files like in the olden days.",dictFileTooBig:"File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",dictInvalidFileType:"You can't upload files of this type.",dictResponseError:"Server responded with {{statusCode}} code.",dictCancelUpload:"Cancel upload",dictCancelUploadConfirmation:"Are you sure you want to cancel this upload?",dictRemoveFile:"Remove file",dictRemoveFileConfirmation:null,dictMaxFilesExceeded:"You can not upload any more files.",accept:function(i,h){return h()},init:function(){return q},forceFallback:!1,fallback:function(){var h,m,l,k,j,i;for(this.element.className=""+this.element.className+" dz-browser-not-supported",i=this.element.getElementsByTagName("div"),k=0,j=i.length;j>k;k++){h=i[k],/(^| )dz-message($| )/.test(h.className)&&(m=h,h.className="dz-message")}return m||(m=e.createElement('<div class="dz-message"><span></span></div>'),this.element.appendChild(m)),l=m.getElementsByTagName("span")[0],l&&(l.textContent=this.options.dictFallbackMessage),this.element.appendChild(this.getFallbackForm())},resize:function(i){var h,k,j;return h={srcX:0,srcY:0,srcWidth:i.width,srcHeight:i.height},k=i.width/i.height,h.optWidth=this.options.thumbnailWidth,h.optHeight=this.options.thumbnailHeight,null==h.optWidth&&null==h.optHeight?(h.optWidth=h.srcWidth,h.optHeight=h.srcHeight):null==h.optWidth?h.optWidth=k*h.optHeight:null==h.optHeight&&(h.optHeight=1/k*h.optWidth),j=h.optWidth/h.optHeight,i.height<h.optHeight||i.width<h.optWidth?(h.trgHeight=h.srcHeight,h.trgWidth=h.srcWidth):k>j?(h.srcHeight=i.height,h.srcWidth=h.srcHeight*j):(h.srcWidth=i.width,h.srcHeight=h.srcWidth/j),h.srcX=(i.width-h.srcWidth)/2,h.srcY=(i.height-h.srcHeight)/2,h},drop:function(){return this.element.classList.remove("dz-drag-hover")},dragstart:q,dragend:function(){return this.element.classList.remove("dz-drag-hover")},dragenter:function(){return this.element.classList.add("dz-drag-hover")},dragover:function(){return this.element.classList.add("dz-drag-hover")},dragleave:function(){return this.element.classList.remove("dz-drag-hover")},paste:q,reset:function(){return this.element.classList.remove("dz-started")},addedfile:function(K){var J,I,H,G,F,E,D,C,B,A,z,y,x;if(this.element===this.previewsContainer&&this.element.classList.add("dz-started"),this.previewsContainer){for(K.previewElement=e.createElement(this.options.previewTemplate.trim()),K.previewTemplate=K.previewElement,this.previewsContainer.appendChild(K.previewElement),A=K.previewElement.querySelectorAll("[data-dz-name]"),G=0,D=A.length;D>G;G++){J=A[G],J.textContent=K.name}for(z=K.previewElement.querySelectorAll("[data-dz-size]"),F=0,C=z.length;C>F;F++){J=z[F],J.innerHTML=this.filesize(K.size)}for(this.options.addRemoveLinks&&(K._removeLink=e.createElement('<a class="dz-remove" href="javascript:undefined;" data-dz-remove>'+this.options.dictRemoveFile+"</a>"),K.previewElement.appendChild(K._removeLink)),I=function(h){return function(i){return i.preventDefault(),i.stopPropagation(),K.status===e.UPLOADING?e.confirm(h.options.dictCancelUploadConfirmation,function(){return h.removeFile(K)}):h.options.dictRemoveFileConfirmation?e.confirm(h.options.dictRemoveFileConfirmation,function(){return h.removeFile(K)}):h.removeFile(K)}}(this),y=K.previewElement.querySelectorAll("[data-dz-remove]"),x=[],E=0,B=y.length;B>E;E++){H=y[E],x.push(H.addEventListener("click",I))}return x}},removedfile:function(i){var h;return i.previewElement&&null!=(h=i.previewElement)&&h.parentNode.removeChild(i.previewElement),this._updateMaxFilesReachedClass()},thumbnail:function(i,h){var x,m,l,k,j;if(i.previewElement){for(i.previewElement.classList.remove("dz-file-preview"),i.previewElement.classList.add("dz-image-preview"),k=i.previewElement.querySelectorAll("[data-dz-thumbnail]"),j=[],m=0,l=k.length;l>m;m++){x=k[m],x.alt=i.name,j.push(x.src=h)}return j}},error:function(i,h){var x,m,l,k,j;if(i.previewElement){for(i.previewElement.classList.add("dz-error"),"String"!=typeof h&&h.error&&(h=h.error),k=i.previewElement.querySelectorAll("[data-dz-errormessage]"),j=[],m=0,l=k.length;l>m;m++){x=k[m],j.push(x.textContent=h)}return j}},errormultiple:q,processing:function(h){return h.previewElement&&(h.previewElement.classList.add("dz-processing"),h._removeLink)?h._removeLink.textContent=this.options.dictCancelUpload:void 0},processingmultiple:q,uploadprogress:function(i,h){var x,m,l,k,j;if(i.previewElement){for(k=i.previewElement.querySelectorAll("[data-dz-uploadprogress]"),j=[],m=0,l=k.length;l>m;m++){x=k[m],j.push(x.style.width=""+h+"%")}return j}},totaluploadprogress:q,sending:q,sendingmultiple:q,success:function(h){return h.previewElement?h.previewElement.classList.add("dz-success"):void 0},successmultiple:q,canceled:function(h){return this.emit("error",h,"Upload canceled.")},canceledmultiple:q,complete:function(h){return h._removeLink?h._removeLink.textContent=this.options.dictRemoveFile:void 0},completemultiple:q,maxfilesexceeded:q,maxfilesreached:q,previewTemplate:'<div class="dz-preview dz-file-preview">\n  <div class="dz-details">\n    <div class="dz-filename"><span data-dz-name></span></div>\n    <div class="dz-size" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n  <div class="dz-success-mark"><span>✔</span></div>\n  <div class="dz-error-mark"><span>✘</span></div>\n  <div class="dz-error-message"><span data-dz-errormessage></span></div>\n</div>'},g=function(){var i,h,x,m,l,k,j;for(m=arguments[0],x=2<=arguments.length?c.call(arguments,1):[],k=0,j=x.length;j>k;k++){h=x[k];for(i in h){l=h[i],m[i]=l}}return m},e.prototype.getAcceptedFiles=function(){var i,h,l,k,j;for(k=this.files,j=[],h=0,l=k.length;l>h;h++){i=k[h],i.accepted&&j.push(i)}return j},e.prototype.getRejectedFiles=function(){var i,h,l,k,j;for(k=this.files,j=[],h=0,l=k.length;l>h;h++){i=k[h],i.accepted||j.push(i)}return j},e.prototype.getFilesWithStatus=function(i){var h,m,l,k,j;for(k=this.files,j=[],m=0,l=k.length;l>m;m++){h=k[m],h.status===i&&j.push(h)}return j},e.prototype.getQueuedFiles=function(){return this.getFilesWithStatus(e.QUEUED)},e.prototype.getUploadingFiles=function(){return this.getFilesWithStatus(e.UPLOADING)},e.prototype.getActiveFiles=function(){var h,l,k,j,i;for(j=this.files,i=[],l=0,k=j.length;k>l;l++){h=j[l],(h.status===e.UPLOADING||h.status===e.QUEUED)&&i.push(h)}return i},e.prototype.init=function(){var i,y,x,m,l,k,j;for("form"===this.element.tagName&&this.element.setAttribute("enctype","multipart/form-data"),this.element.classList.contains("dropzone")&&!this.element.querySelector(".dz-message")&&this.element.appendChild(e.createElement('<div class="dz-default dz-message"><span>'+this.options.dictDefaultMessage+"</span></div>")),this.clickableElements.length&&(x=function(h){return function(){return h.hiddenFileInput&&document.body.removeChild(h.hiddenFileInput),h.hiddenFileInput=document.createElement("input"),h.hiddenFileInput.setAttribute("type","file"),(null==h.options.maxFiles||h.options.maxFiles>1)&&h.hiddenFileInput.setAttribute("multiple","multiple"),h.hiddenFileInput.className="dz-hidden-input",null!=h.options.acceptedFiles&&h.hiddenFileInput.setAttribute("accept",h.options.acceptedFiles),h.hiddenFileInput.style.visibility="hidden",h.hiddenFileInput.style.position="absolute",h.hiddenFileInput.style.top="0",h.hiddenFileInput.style.left="0",h.hiddenFileInput.style.height="0",h.hiddenFileInput.style.width="0",document.body.appendChild(h.hiddenFileInput),h.hiddenFileInput.addEventListener("change",function(){var z,C,B,A;if(C=h.hiddenFileInput.files,C.length){for(B=0,A=C.length;A>B;B++){z=C[B],h.addFile(z)}}return x()})}}(this))(),this.URL=null!=(k=window.URL)?k:window.webkitURL,j=this.events,m=0,l=j.length;l>m;m++){i=j[m],this.on(i,this.options[i])}return this.on("uploadprogress",function(h){return function(){return h.updateTotalUploadProgress()}}(this)),this.on("removedfile",function(h){return function(){return h.updateTotalUploadProgress()}}(this)),this.on("canceled",function(h){return function(z){return h.emit("complete",z)}}(this)),this.on("complete",function(h){return function(){return 0===h.getUploadingFiles().length&&0===h.getQueuedFiles().length?setTimeout(function(){return h.emit("queuecomplete")},0):void 0}}(this)),y=function(h){return h.stopPropagation(),h.preventDefault?h.preventDefault():h.returnValue=!1},this.listeners=[{element:this.element,events:{dragstart:function(h){return function(z){return h.emit("dragstart",z)}}(this),dragenter:function(h){return function(z){return y(z),h.emit("dragenter",z)}}(this),dragover:function(h){return function(z){var B;try{B=z.dataTransfer.effectAllowed}catch(A){}return z.dataTransfer.dropEffect="move"===B||"linkMove"===B?"move":"copy",y(z),h.emit("dragover",z)}}(this),dragleave:function(h){return function(z){return h.emit("dragleave",z)}}(this),drop:function(h){return function(z){return y(z),h.drop(z)}}(this),dragend:function(h){return function(z){return h.emit("dragend",z)}}(this)}}],this.clickableElements.forEach(function(h){return function(z){return h.listeners.push({element:z,events:{click:function(A){return z!==h.element||A.target===h.element||e.elementInside(A.target,h.element.querySelector(".dz-message"))?h.hiddenFileInput.click():void 0}}})}}(this)),this.enable(),this.options.init.call(this)},e.prototype.destroy=function(){var h;return this.disable(),this.removeAllFiles(!0),(null!=(h=this.hiddenFileInput)?h.parentNode:void 0)&&(this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput),this.hiddenFileInput=null),delete this.element.dropzone,e.instances.splice(e.instances.indexOf(this),1)},e.prototype.updateTotalUploadProgress=function(){var j,i,z,y,x,m,l,k;if(y=0,z=0,j=this.getActiveFiles(),j.length){for(k=this.getActiveFiles(),m=0,l=k.length;l>m;m++){i=k[m],y+=i.upload.bytesSent,z+=i.upload.total}x=100*y/z}else{x=100}return this.emit("totaluploadprogress",x,z,y)},e.prototype._getParamName=function(h){return"function"==typeof this.options.paramName?this.options.paramName(h):""+this.options.paramName+(this.options.uploadMultiple?"["+h+"]":"")},e.prototype.getFallbackForm=function(){var h,k,j,i;return(h=this.getExistingFallback())?h:(j='<div class="dz-fallback">',this.options.dictFallbackText&&(j+="<p>"+this.options.dictFallbackText+"</p>"),j+='<input type="file" name="'+this._getParamName(0)+'" '+(this.options.uploadMultiple?'multiple="multiple"':void 0)+' /><input type="submit" value="Upload!"></div>',k=e.createElement(j),"FORM"!==this.element.tagName?(i=e.createElement('<form action="'+this.options.url+'" enctype="multipart/form-data" method="'+this.options.method+'"></form>'),i.appendChild(k)):(this.element.setAttribute("enctype","multipart/form-data"),this.element.setAttribute("method",this.options.method)),null!=i?i:k)},e.prototype.getExistingFallback=function(){var i,h,m,l,k,j;for(h=function(y){var x,A,z;for(A=0,z=y.length;z>A;A++){if(x=y[A],/(^| )fallback($| )/.test(x.className)){return x}}},j=["div","form"],l=0,k=j.length;k>l;l++){if(m=j[l],i=h(this.element.getElementsByTagName(m))){return i}}},e.prototype.setupEventListeners=function(){var i,h,x,m,l,k,j;for(k=this.listeners,j=[],m=0,l=k.length;l>m;m++){i=k[m],j.push(function(){var z,y;z=i.events,y=[];for(h in z){x=z[h],y.push(i.element.addEventListener(h,x,!1))}return y}())}return j},e.prototype.removeEventListeners=function(){var i,h,x,m,l,k,j;for(k=this.listeners,j=[],m=0,l=k.length;l>m;m++){i=k[m],j.push(function(){var z,y;z=i.events,y=[];for(h in z){x=z[h],y.push(i.element.removeEventListener(h,x,!1))}return y}())}return j},e.prototype.disable=function(){var i,h,l,k,j;for(this.clickableElements.forEach(function(m){return m.classList.remove("dz-clickable")}),this.removeEventListeners(),k=this.files,j=[],h=0,l=k.length;l>h;h++){i=k[h],j.push(this.cancelUpload(i))}return j},e.prototype.enable=function(){return this.clickableElements.forEach(function(h){return h.classList.add("dz-clickable")}),this.setupEventListeners()},e.prototype.filesize=function(i){var h;return i>=109951162777.6?(i/=109951162777.6,h="TiB"):i>=107374182.4?(i/=107374182.4,h="GiB"):i>=104857.6?(i/=104857.6,h="MiB"):i>=102.4?(i/=102.4,h="KiB"):(i=10*i,h="b"),"<strong>"+Math.round(i)/10+"</strong> "+h},e.prototype._updateMaxFilesReachedClass=function(){return null!=this.options.maxFiles&&this.getAcceptedFiles().length>=this.options.maxFiles?(this.getAcceptedFiles().length===this.options.maxFiles&&this.emit("maxfilesreached",this.files),this.element.classList.add("dz-max-files-reached")):this.element.classList.remove("dz-max-files-reached")},e.prototype.drop=function(i){var h,j;i.dataTransfer&&(this.emit("drop",i),h=i.dataTransfer.files,h.length&&(j=i.dataTransfer.items,j&&j.length&&null!=j[0].webkitGetAsEntry?this._addFilesFromItems(j):this.handleFiles(h)))},e.prototype.paste=function(i){var h,j;if(null!=(null!=i&&null!=(j=i.clipboardData)?j.items:void 0)){return this.emit("paste",i),h=i.clipboardData.items,h.length?this._addFilesFromItems(h):void 0}},e.prototype.handleFiles=function(i){var h,l,k,j;for(j=[],l=0,k=i.length;k>l;l++){h=i[l],j.push(this.addFile(h))}return j},e.prototype._addFilesFromItems=function(i){var h,m,l,k,j;for(j=[],l=0,k=i.length;k>l;l++){m=i[l],j.push(null!=m.webkitGetAsEntry&&(h=m.webkitGetAsEntry())?h.isFile?this.addFile(m.getAsFile()):h.isDirectory?this._addFilesFromDirectory(h,h.name):void 0:null!=m.getAsFile?null==m.kind||"file"===m.kind?this.addFile(m.getAsFile()):void 0:void 0)}return j},e.prototype._addFilesFromDirectory=function(i,h){var k,j;return k=i.createReader(),j=function(l){return function(z){var y,x,m;for(x=0,m=z.length;m>x;x++){y=z[x],y.isFile?y.file(function(A){return l.options.ignoreHiddenFiles&&"."===A.name.substring(0,1)?void 0:(A.fullPath=""+h+"/"+A.name,l.addFile(A))}):y.isDirectory&&l._addFilesFromDirectory(y,""+h+"/"+y.name)}}}(this),k.readEntries(j,function(l){return"undefined"!=typeof console&&null!==console&&"function"==typeof console.log?console.log(l):void 0})},e.prototype.accept=function(h,i){return h.size>1024*this.options.maxFilesize*1024?i(this.options.dictFileTooBig.replace("{{filesize}}",Math.round(h.size/1024/10.24)/100).replace("{{maxFilesize}}",this.options.maxFilesize)):e.isValidFile(h,this.options.acceptedFiles)?null!=this.options.maxFiles&&this.getAcceptedFiles().length>=this.options.maxFiles?(i(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}",this.options.maxFiles)),this.emit("maxfilesexceeded",h)):this.options.accept.call(this,h,i):i(this.options.dictInvalidFileType)},e.prototype.addFile=function(h){return h.upload={progress:0,total:h.size,bytesSent:0},this.files.push(h),h.status=e.ADDED,this.emit("addedfile",h),this._enqueueThumbnail(h),this.accept(h,function(i){return function(j){return j?(h.accepted=!1,i._errorProcessing([h],j)):(h.accepted=!0,i.options.autoQueue&&i.enqueueFile(h)),i._updateMaxFilesReachedClass()}}(this))},e.prototype.enqueueFiles=function(i){var h,k,j;for(k=0,j=i.length;j>k;k++){h=i[k],this.enqueueFile(h)}return null},e.prototype.enqueueFile=function(h){if(h.status!==e.ADDED||h.accepted!==!0){throw new Error("This file can't be queued because it has already been processed or was rejected.")}return h.status=e.QUEUED,this.options.autoProcessQueue?setTimeout(function(i){return function(){return i.processQueue()}}(this),0):void 0},e.prototype._thumbnailQueue=[],e.prototype._processingThumbnail=!1,e.prototype._enqueueThumbnail=function(h){return this.options.createImageThumbnails&&h.type.match(/image.*/)&&h.size<=1024*this.options.maxThumbnailFilesize*1024?(this._thumbnailQueue.push(h),setTimeout(function(i){return function(){return i._processThumbnailQueue()}}(this),0)):void 0},e.prototype._processThumbnailQueue=function(){return this._processingThumbnail||0===this._thumbnailQueue.length?void 0:(this._processingThumbnail=!0,this.createThumbnail(this._thumbnailQueue.shift(),function(h){return function(){return h._processingThumbnail=!1,h._processThumbnailQueue()}}(this)))},e.prototype.removeFile=function(h){return h.status===e.UPLOADING&&this.cancelUpload(h),this.files=p(this.files,h),this.emit("removedfile",h),0===this.files.length?this.emit("reset"):void 0},e.prototype.removeAllFiles=function(h){var l,k,j,i;for(null==h&&(h=!1),i=this.files.slice(),k=0,j=i.length;j>k;k++){l=i[k],(l.status!==e.UPLOADING||h)&&this.removeFile(l)}return null},e.prototype.createThumbnail=function(i,h){var j;return j=new FileReader,j.onload=function(k){return function(){var l;return l=document.createElement("img"),l.onload=function(){var E,D,C,B,A,z,y,x;return i.width=l.width,i.height=l.height,C=k.options.resize.call(k,i),null==C.trgWidth&&(C.trgWidth=C.optWidth),null==C.trgHeight&&(C.trgHeight=C.optHeight),E=document.createElement("canvas"),D=E.getContext("2d"),E.width=C.trgWidth,E.height=C.trgHeight,r(D,l,null!=(A=C.srcX)?A:0,null!=(z=C.srcY)?z:0,C.srcWidth,C.srcHeight,null!=(y=C.trgX)?y:0,null!=(x=C.trgY)?x:0,C.trgWidth,C.trgHeight),B=E.toDataURL("image/png"),k.emit("thumbnail",i,B),null!=h?h():void 0},l.src=j.result}}(this),j.readAsDataURL(i)},e.prototype.processQueue=function(){var i,h,k,j;if(h=this.options.parallelUploads,k=this.getUploadingFiles().length,i=k,!(k>=h)&&(j=this.getQueuedFiles(),j.length>0)){if(this.options.uploadMultiple){return this.processFiles(j.slice(0,h-k))}for(;h>i;){if(!j.length){return}this.processFile(j.shift()),i++}}},e.prototype.processFile=function(h){return this.processFiles([h])},e.prototype.processFiles=function(h){var k,j,i;for(j=0,i=h.length;i>j;j++){k=h[j],k.processing=!0,k.status=e.UPLOADING,this.emit("processing",k)}return this.options.uploadMultiple&&this.emit("processingmultiple",h),this.uploadFiles(h)},e.prototype._getFilesWithXhr=function(i){var h,j;return j=function(){var x,m,l,k;for(l=this.files,k=[],x=0,m=l.length;m>x;x++){h=l[x],h.xhr===i&&k.push(h)}return k}.call(this)},e.prototype.cancelUpload=function(j){var A,z,y,x,m,l,k;if(j.status===e.UPLOADING){for(z=this._getFilesWithXhr(j.xhr),y=0,m=z.length;m>y;y++){A=z[y],A.status=e.CANCELED}for(j.xhr.abort(),x=0,l=z.length;l>x;x++){A=z[x],this.emit("canceled",A)}this.options.uploadMultiple&&this.emit("canceledmultiple",z)}else{((k=j.status)===e.ADDED||k===e.QUEUED)&&(j.status=e.CANCELED,this.emit("canceled",j),this.options.uploadMultiple&&this.emit("canceledmultiple",[j]))}return this.options.autoProcessQueue?this.processQueue():void 0},e.prototype.uploadFile=function(h){return this.uploadFiles([h])},e.prototype.uploadFiles=function(ap){var ao,an,am,al,ak,aj,ai,ah,ag,af,ae,ad,ac,aa,Y,W,U,S,Q,O,M,K,J,ab,Z,X,V,T,R,P,N,L;for(U=new XMLHttpRequest,S=0,K=ap.length;K>S;S++){ao=ap[S],ao.xhr=U}U.open(this.options.method,this.options.url,!0),U.withCredentials=!!this.options.withCredentials,aa=null,am=function(h){return function(){var k,j,i;for(i=[],k=0,j=ap.length;j>k;k++){ao=ap[k],i.push(h._errorProcessing(ap,aa||h.options.dictResponseError.replace("{{statusCode}}",U.status),U))}return i}}(this),Y=function(h){return function(G){var F,E,D,C,B,A,z,y,x;if(null!=G){for(E=100*G.loaded/G.total,D=0,A=ap.length;A>D;D++){ao=ap[D],ao.upload={progress:E,total:G.total,bytesSent:G.loaded}}}else{for(F=!0,E=100,C=0,z=ap.length;z>C;C++){ao=ap[C],(100!==ao.upload.progress||ao.upload.bytesSent!==ao.upload.total)&&(F=!1),ao.upload.progress=E,ao.upload.bytesSent=ao.upload.total}if(F){return}}for(x=[],B=0,y=ap.length;y>B;B++){ao=ap[B],x.push(h.emit("uploadprogress",ao,E,ao.upload.bytesSent))}return x}}(this),U.onload=function(h){return function(k){var j;if(ap[0].status!==e.CANCELED&&4===U.readyState){if(aa=U.responseText,U.getResponseHeader("content-type")&&~U.getResponseHeader("content-type").indexOf("application/json")){try{aa=JSON.parse(aa)}catch(i){k=i,aa="Invalid JSON response from server."}}return Y(),200<=(j=U.status)&&300>j?h._finished(ap,aa,k):am()}}}(this),U.onerror=function(){return function(){return ap[0].status!==e.CANCELED?am():void 0}}(this),ac=null!=(V=U.upload)?V:U,ac.onprogress=Y,aj={Accept:"application/json","Cache-Control":"no-cache","X-Requested-With":"XMLHttpRequest"},this.options.headers&&g(aj,this.options.headers);for(al in aj){ak=aj[al],U.setRequestHeader(al,ak)}if(an=new FormData,this.options.params){T=this.options.params;for(ae in T){W=T[ae],an.append(ae,W)}}for(Q=0,J=ap.length;J>Q;Q++){ao=ap[Q],this.emit("sending",ao,U,an)}if(this.options.uploadMultiple&&this.emit("sendingmultiple",ap,U,an),"FORM"===this.element.tagName){for(R=this.element.querySelectorAll("input, textarea, select, button"),O=0,ab=R.length;ab>O;O++){if(ah=R[O],ag=ah.getAttribute("name"),af=ah.getAttribute("type"),"SELECT"===ah.tagName&&ah.hasAttribute("multiple")){for(P=ah.options,M=0,Z=P.length;Z>M;M++){ad=P[M],ad.selected&&an.append(ag,ad.value)}}else{(!af||"checkbox"!==(N=af.toLowerCase())&&"radio"!==N||ah.checked)&&an.append(ag,ah.value)}}}for(ai=X=0,L=ap.length-1;L>=0?L>=X:X>=L;ai=L>=0?++X:--X){an.append(this._getParamName(ai),ap[ai],ap[ai].name)}return U.send(an)},e.prototype._finished=function(h,m,l){var k,j,i;for(j=0,i=h.length;i>j;j++){k=h[j],k.status=e.SUCCESS,this.emit("success",k,m,l),this.emit("complete",k)}return this.options.uploadMultiple&&(this.emit("successmultiple",h,m,l),this.emit("completemultiple",h)),this.options.autoProcessQueue?this.processQueue():void 0},e.prototype._errorProcessing=function(h,m,l){var k,j,i;for(j=0,i=h.length;i>j;j++){k=h[j],k.status=e.ERROR,this.emit("error",k,m,l),this.emit("complete",k)}return this.options.uploadMultiple&&(this.emit("errormultiple",h,m,l),this.emit("completemultiple",h)),this.options.autoProcessQueue?this.processQueue():void 0},e}(v),w.version="3.10.2",w.options={},w.optionsForElement=function(e){return e.getAttribute("id")?w.options[u(e.getAttribute("id"))]:void 0},w.instances=[],w.forElement=function(e){if("string"==typeof e&&(e=document.querySelector(e)),null==(null!=e?e.dropzone:void 0)){throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.")}return e.dropzone},w.autoDiscover=!0,w.discover=function(){var h,m,l,k,j,i;for(document.querySelectorAll?l=document.querySelectorAll(".dropzone"):(l=[],h=function(x){var g,A,z,y;for(y=[],A=0,z=x.length;z>A;A++){g=x[A],y.push(/(^| )dropzone($| )/.test(g.className)?l.push(g):void 0)}return y},h(document.getElementsByTagName("div")),h(document.getElementsByTagName("form"))),i=[],k=0,j=l.length;j>k;k++){m=l[k],i.push(w.optionsForElement(m)!==!1?new w(m):void 0)}return i},w.blacklistedBrowsers=[/opera.*Macintosh.*version\/12/i],w.isBrowserSupported=function(){var g,k,j,i,h;if(g=!0,window.File&&window.FileReader&&window.FileList&&window.Blob&&window.FormData&&document.querySelector){if("classList" in document.createElement("a")){for(h=w.blacklistedBrowsers,j=0,i=h.length;i>j;j++){k=h[j],k.test(navigator.userAgent)&&(g=!1)}}else{g=!1}}else{g=!1}return g},p=function(h,g){var l,k,j,i;for(i=[],k=0,j=h.length;j>k;k++){l=h[k],l!==g&&i.push(l)}return i},u=function(e){return e.replace(/[\-_](\w)/g,function(f){return f.charAt(1).toUpperCase()})},w.createElement=function(f){var e;return e=document.createElement("div"),e.innerHTML=f,e.childNodes[0]},w.elementInside=function(f,e){if(f===e){return !0}for(;f=f.parentNode;){if(f===e){return !0}}return !1},w.getElement=function(f,e){var g;if("string"==typeof f?g=document.querySelector(f):null!=f.nodeType&&(g=f),null==g){throw new Error("Invalid `"+e+"` option provided. Please provide a CSS selector or a plain HTML element.")}return g},w.getElements=function(F,E){var D,C,B,A,z,y,x,m;if(F instanceof Array){B=[];try{for(A=0,y=F.length;y>A;A++){C=F[A],B.push(this.getElement(C,E))}}catch(l){D=l,B=null}}else{if("string"==typeof F){for(B=[],m=document.querySelectorAll(F),z=0,x=m.length;x>z;z++){C=m[z],B.push(C)}}else{null!=F.nodeType&&(B=[F])}}if(null==B||!B.length){throw new Error("Invalid `"+E+"` option provided. Please provide a CSS selector, a plain HTML element or a list of those.")}return B},w.confirm=function(f,e,g){return window.confirm(f)?e():null!=g?g():void 0},w.isValidFile=function(i,h){var x,m,l,k,j;if(!h){return !0}for(h=h.split(","),m=i.type,x=m.replace(/\/.*$/,""),k=0,j=h.length;j>k;k++){if(l=h[k],l=l.trim(),"."===l.charAt(0)){if(-1!==i.name.toLowerCase().indexOf(l.toLowerCase(),i.name.length-l.length)){return !0}}else{if(/\/\*$/.test(l)){if(x===l.replace(/\/.*$/,"")){return !0}}else{if(m===l){return !0}}}}return !1},"undefined"!=typeof jQuery&&null!==jQuery&&(jQuery.fn.dropzone=function(e){return this.each(function(){return new w(this,e)})}),"undefined"!=typeof d&&null!==d?d.exports=w:window.Dropzone=w,w.ADDED="added",w.QUEUED="queued",w.ACCEPTED=w.QUEUED,w.UPLOADING="uploading",w.PROCESSING=w.UPLOADING,w.CANCELED="canceled",w.ERROR="error",w.SUCCESS="success",s=function(F){var E,D,C,B,A,z,y,x,m,l;for(y=F.naturalWidth,z=F.naturalHeight,D=document.createElement("canvas"),D.width=1,D.height=z,C=D.getContext("2d"),C.drawImage(F,0,0),B=C.getImageData(0,0,1,z).data,l=0,A=z,x=z;x>l;){E=B[4*(x-1)+3],0===E?A=x:l=x,x=A+l>>1}return m=x/z,0===m?1:m},r=function(F,E,D,C,B,A,z,y,x,m){var g;return g=s(E),F.drawImage(E,D,C,B,A,z,y,x,m/g)},t=function(H,G){var F,E,D,C,B,A,z,y,x;if(D=!1,x=!0,E=H.document,y=E.documentElement,F=E.addEventListener?"addEventListener":"attachEvent",z=E.addEventListener?"removeEventListener":"detachEvent",A=E.addEventListener?"":"on",C=function(e){return"readystatechange"!==e.type||"complete"===E.readyState?(("load"===e.type?H:E)[z](A+e.type,C,!1),!D&&(D=!0)?G.call(H,e.type||e):void 0):void 0},B=function(){var f;try{y.doScroll("left")}catch(e){return f=e,void setTimeout(B,50)}return C("poll")},"complete"!==E.readyState){if(E.createEventObject&&y.doScroll){try{x=!H.frameElement}catch(m){}x&&B()}return E[F](A+"DOMContentLoaded",C,!1),E[F](A+"readystatechange",C,!1),H[F](A+"load",C,!1)}},w._autoDiscoverFunction=function(){return w.autoDiscover?w.discover():void 0},t(window,w._autoDiscoverFunction)}).call(this)}),"object"==typeof exports?module.exports=b("dropzone"):"function"==typeof define&&define.amd?define([],function(){return b("dropzone")}):this.Dropzone=b("dropzone")}();