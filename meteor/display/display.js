Courts = new Meteor.Collection("courts");
Connections = new Meteor.Collection("connections");


if (Meteor.isClient) {

    var thisCourt;
    var thisOldCourt;
    //Meteor.call("getCourt",function(error,result) {
    //    if(error){
    //        //console.log(error.reason);
    //    }
    //    else{
    //        //Template.singleTable.court(result);
    //        thisCourt = result;
    //    }
    //});


    //Template.singleTable.rendered = function() {
    //    console.log("rendered");
    //}

    Template.singleTable.connection = function() {

        Meteor.call("getCourt",function(error,result) {
            if(error){
                //console.log(error.reason);
            }
            else{
                //Template.singleTable.court(result);
                console.log("got new court " + result);
                thisCourt = result;
                if (thisCourt != thisOldCourt) {
                    document.body.innerHTML = "";
                    UI.insert(UI.render(Template.singleTable), document.body);
                    //$("#vs").hide();

                }
                thisOldCourt = result;
            }
        });
        //var i = 0;
        //while ( thisCourt == thisCourtNow && i < 2000) {
        //    console.log("waiting ..." + thisCourt);
        //    i = i + 1;
        //}
        //console.log("court changed from " + thisCourt + " to " + thisCourtNow);
        var r = "";
        Connections.find().forEach(function(row) {
             r = r + " " + row.time;
        });

        //console.log(r);
        //
        //if (Connections.findOne({_id: "device-192.168.1.49-Meteor-Server"})) {
        //    return Connections.findOne({_id: "device-192.168.1.49-Meteor-Server"}).time;
        //} else {
        //    return 0;
        //}
        return r;
    }


    Template.singleTable.court = function() {
        Meteor.call("registerMonitor");


        var maxpoints = 21;
        //if (thisCourt == undefined) {
            //thisCourt = 1;
        //}
        var c = Courts.findOne({_id: 'court'+thisCourt});

        var currentSet = 0;

        if(c != undefined) {
            //console.log("running template");
            // set gray borders -> no bumping around
            c.framep1s1 = 'grayframe'; c.framep1s2 = 'grayframe'; c.framep1s3 = 'grayframe';
            c.framep2s1 = 'grayframe'; c.framep2s2 = 'grayframe'; c.framep2s3 = 'grayframe';

            // set green markers for service
            if(c.set1p1>0 || c.set1p2>0) currentSet = 1;
            if(c.set2p1>0 || c.set2p2>0) currentSet = 2;
            if(c.set3p1>0 || c.set3p2>0) currentSet = 3;
            eval('c.framep' + c.service + 's' + currentSet + ' = "greenframe";');

            // set borders for won sets
            for(var i=0;i<9;i++)
            {
              if(c.set1p1==(maxpoints+i) && c.set1p2<(maxpoints-1+i)) { c.framep1s1 = 'redframe'; }
              if(c.set1p2==(maxpoints+i) && c.set1p1<(maxpoints-1+i)) { c.framep2s1 = 'redframe'; }
            }
            for(var i=0;i<9;i++)
            {
              if(c.set2p1==(maxpoints+i) && c.set2p2<(maxpoints-1+i)) { c.framep1s2 = 'redframe'; }
              if(c.set2p2==(maxpoints+i) && c.set2p1<(maxpoints-1+i)) { c.framep2s2 = 'redframe'; }
            }
            for(var i=0;i<9;i++)
            {
              if(c.set3p1==(maxpoints+i) && c.set3p2<(maxpoints-1+i)) { c.framep1s3 = 'redframe'; }
              if(c.set3p2==(maxpoints+i) && c.set3p1<(maxpoints-1+i)) { c.framep2s3 = 'redframe'; }
            }
            if(c.set1p1==30) c.framep1s1 = 'redframe';
            if(c.set1p2==30) c.framep2s1 = 'redframe';
            if(c.set2p1==30) c.framep1s2 = 'redframe';
            if(c.set2p2==30) c.framep2s2 = 'redframe';
            if(c.set3p1==30) c.framep1s3 = 'redframe';
            if(c.set3p2==30) c.framep2s3 = 'redframe';

            // get rid of 3rd set if its unused
            if(c.set3p1 == 0 && c.set3p2 ==0) {
              c.set3p1 = '';
              c.set3p2 = '';
            }

            if(c.set1p1 == undefined && c.set1p2 == undefined) {
                console.log("disabled scoreboard");
                $("#scoresp1").hide();
                $("#vs").show();
                $("#scoresp2").hide();
            } else {
                console.log("enabled scoreboard");
                $("#scoresp1").show();
                $("#vs").hide();
                $("#scoresp2").show();
            }
            return c;
        }
    };
}

if (Meteor.isServer) {
  Meteor.startup(function () {

    // code to run on server at startup
    collectionApi = new CollectionAPI({ authToken: '97f0ad9e24ca5e0408a269748d7fe0a0' });
    collectionApi.addCollection(Courts, 'courts');
    collectionApi.addCollection(Connections, 'connections');
    collectionApi.start();
  });

    Meteor.methods({registerMonitor: function() {
        var clientAddress = this.connection.clientAddress;
        if (clientAddress == '127.0.0.1') {
            clientAddress = '-Server';
        } else {
            clientAddress = '-' + clientAddress.split('.')[3];
        }
        return Meteor.http.call("GET","http://192.168.2.104/badminton-livescore-v2/output.php?debugid=Meteor" + clientAddress);
    } });

    Meteor.methods({getCourt: function() {

        var clientAddress = this.connection.clientAddress;
        if (clientAddress == '127.0.0.1') {
            clientAddress = '-Server';
        } else {
            clientAddress = '-' + clientAddress.split('.')[3];
        }
        return Connections.findOne({_id: "device-192.168.2.104-Meteor"+clientAddress}).court;

    } });

}
