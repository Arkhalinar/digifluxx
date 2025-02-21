if(typeof(_digiAdSpec) == "undefined") {
  _digiAdSpec = {
    arrWithElements: [],
    urlForGet: 'https://digifluxx.com/special/sbtl',
    urlForSet: 'https://digifluxx.com/special/ac',
    init: function () {
      this.looklang();
    },
    get: function (info) {
      let xhr = new XMLHttpRequest();
      let els = document.getElementsByClassName('digibnr_'+info);
      xhr.open("POST", this.urlForGet);
      xhr.setRequestHeader('Content-type', 'text/plain; charset=utf-8');
      xhr.send(info+'_'+els.length+'_'+this.autolang);
      xhr.onload = function() {
        let responseObj = JSON.parse(xhr.response);
        if(!responseObj.error) {
          for (let i = 0; i < els.length; i++) {
            if(responseObj["bans"][i]['type'] == 0) {
              els[i].innerHTML = "<img style='cursor:pointer;width:"+responseObj["bans"][i].w+"px;height:"+responseObj["bans"][i].h+"px;' src='"+responseObj["bans"][i].url+"' onclick='_digiAdSpec.set(\""+responseObj["bans"][i].adurl+"\", "+responseObj["bans"][i].id+", "+responseObj.bid+")'>";
              els[i].setAttribute('style', "width:"+responseObj["bans"][i].w+"px;height:"+responseObj["bans"][i].h+"px;");
            }else{
              els[i].innerHTML = "<p style='cursor:pointer;width:"+responseObj["bans"][i].w+"px;height:"+responseObj["bans"][i].h+"px;' onclick='_digiAdSpec.set(\""+responseObj["bans"][i].adurl+"\", "+responseObj["bans"][i].id+", "+responseObj.bid+")'><span style='font-weight: bold; font-size: 105%;'>"+responseObj["bans"][i].head+"</span><br><span>"+responseObj["bans"][i].body+"</span></p>";
              els[i].setAttribute('style', "width:"+responseObj["bans"][i].w+"px;height:"+responseObj["bans"][i].h+"px;");
            }
          }
        }
      };
    },
    set: function (adurl, id, bid) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", this.urlForSet);
      xhr.setRequestHeader('Content-type', 'text/plain; charset=utf-8');
      xhr.send(bid+'_'+id);
      setTimeout('window.open(\''+adurl+'\')', 200);
    },
    looklang: function() {
      let language = window.navigator ? (window.navigator.language || window.navigator.systemLanguage || window.navigator.userLanguage) : "en";
      language = language.substr(0, 2).toLowerCase();
      this.autolang = language;
    },
    save: function(el) {
      this.arrWithElements.push(el);
    },
    isIsset: function(el) {
      return this.arrWithElements.includes(el);
    }
  }
  _digiAdSpec.init();
}

if(!_digiAdSpec.isIsset('<?php echo $special_id;?>')) {
  document.addEventListener('DOMContentLoaded', function() {
    _digiAdSpec.get('<?php echo $special_id;?>');
  });
  _digiAdSpec.save('<?php echo $special_id;?>');
}