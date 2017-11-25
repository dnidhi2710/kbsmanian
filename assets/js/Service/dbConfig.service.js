app.service('dbConfigService', function () {
    
    this.getUrl = function(){
        return "http://localhost:8888/kbs/service/";
    };
    this.getsampleUrl = function(){
          return "http://localhost:8888/kbs/";
    };
    this.getJobid = function(){
        return "/2017-18";
    };
    return this;
});