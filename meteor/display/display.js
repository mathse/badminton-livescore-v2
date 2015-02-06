Courts = new Meteor.Collection("courts");
Connections = new Meteor.Collection("connections");
Control = new Meteor.Collection("control");
var colorCounter = 0;
var colors = ["blue","red","lime","purple","orange","green","yellow","magenta","lime","darkcyan"];

if (Meteor.isClient) {
    var thisCourt;
    var thisOldCourt;

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

        var r = "";
        Connections.find().forEach(function(row) {
            r = r + " " + row.time;
        });
        return r;
    }

    Template.courtTable.hostAddress = function() {
        //console.log(location.hostname);
        return location.hostname;
    }

    Template.singleTable.hostAddress = function() {
        //console.log(location.hostname);
        return location.hostname;
    }

    Template.singleTable.control = function() {
        if(Control.findOne({_id: 'BackgroundTime'}).value != 0) {
            Meteor.call("getDeviceId",function(error,result) {
                    if (error) {
                        //console.log(error.reason);
                    }
                    else {

                        $('body').css('backgroundColor', Connections.findOne({_id: result}).color);
                    }
                }
            );

        } else {
            $('body').css('backgroundColor', 'black');
        }
        console.log("colorchange");
        return Control.findOne({_id: 'BackgroundTime'}).value;
    }

    Template.singleTable.court = function() {
        Meteor.call("registerMonitor");


        var maxpoints = 21;
        var displayCourtCount = 1;
        var c = {};
        var displayContent = [];

        if(thisCourt > 0) {

            displayContent[0] = Courts.findOne({_id: 'court'+thisCourt});
            c.courts = displayContent;
            c.isSingleCourt = true;
            console.log(c);
        }
        if(thisCourt == "-2") {
            for(var i = 0; i < 2; i++) {
                displayContent[i] = Courts.findOne({_id: 'court'+(i+1)});
            }
            c.courts = displayContent;
            c.isTwoCourts = true;
            displayCourtCount = 2;
        }
        if(thisCourt == "-6") {
            for(var i = 0; i < 6; i++) {
                displayContent[i] = Courts.findOne({_id: 'court'+(i+1)});
            }
            c.courts = displayContent;
            c.isSixCourts = true;
            displayCourtCount = 6;
        }
        if(thisCourt == "-12") {
            for(var i = 0; i < 12; i++) {
                displayContent[i] = Courts.findOne({_id: 'court'+(i+1)});
            }
            c.courts = displayContent;
            c.isTwelveCourts = true;

            //c.isTwelveCourts
            displayCourtCount = 12;
        }

        for(var displayCourt = 0; displayCourt < displayCourtCount; displayCourt++ ) {
            var currentSet = 0;
            c.courts[displayCourt].thisCourtId = displayCourt;
            // set gray borders -> no bumping around
            c.courts[displayCourt].framep1s1 = 'grayframe'; c.courts[displayCourt].framep1s2 = 'grayframe'; c.courts[displayCourt].framep1s3 = 'grayframe';
            c.courts[displayCourt].framep2s1 = 'grayframe'; c.courts[displayCourt].framep2s2 = 'grayframe'; c.courts[displayCourt].framep2s3 = 'grayframe';

            // set green markers for service
            if(c.courts[displayCourt].set1p1>0 || c.courts[displayCourt].set1p2>0) currentSet = 1;
            if(c.courts[displayCourt].set2p1>0 || c.courts[displayCourt].set2p2>0) currentSet = 2;
            if(c.courts[displayCourt].set3p1>0 || c.courts[displayCourt].set3p2>0) currentSet = 3;
            eval('c.courts[displayCourt].framep' + c.courts[displayCourt].service + 's' + currentSet + ' = "greenframe";');

            // set borders for won sets
            for(var i=0;i<9;i++)
            {
                if(c.courts[displayCourt].set1p1==(maxpoints+i) && c.courts[displayCourt].set1p2<(maxpoints-1+i)) { c.courts[displayCourt].framep1s1 = 'redframe'; }
                if(c.courts[displayCourt].set1p2==(maxpoints+i) && c.courts[displayCourt].set1p1<(maxpoints-1+i)) { c.courts[displayCourt].framep2s1 = 'redframe'; }
            }
            for(var i=0;i<9;i++)
            {
                if(c.courts[displayCourt].set2p1==(maxpoints+i) && c.courts[displayCourt].set2p2<(maxpoints-1+i)) { c.courts[displayCourt].framep1s2 = 'redframe'; }
                if(c.courts[displayCourt].set2p2==(maxpoints+i) && c.courts[displayCourt].set2p1<(maxpoints-1+i)) { c.courts[displayCourt].framep2s2 = 'redframe'; }
            }
            for(var i=0;i<9;i++)
            {
                if(c.courts[displayCourt].set3p1==(maxpoints+i) && c.courts[displayCourt].set3p2<(maxpoints-1+i)) { c.courts[displayCourt].framep1s3 = 'redframe'; }
                if(c.courts[displayCourt].set3p2==(maxpoints+i) && c.courts[displayCourt].set3p1<(maxpoints-1+i)) { c.courts[displayCourt].framep2s3 = 'redframe'; }
            }
            if(c.courts[displayCourt].set1p1==30) c.courts[displayCourt].framep1s1 = 'redframe';
            if(c.courts[displayCourt].set1p2==30) c.courts[displayCourt].framep2s1 = 'redframe';
            if(c.courts[displayCourt].set2p1==30) c.courts[displayCourt].framep1s2 = 'redframe';
            if(c.courts[displayCourt].set2p2==30) c.courts[displayCourt].framep2s2 = 'redframe';
            if(c.courts[displayCourt].set3p1==30) c.courts[displayCourt].framep1s3 = 'redframe';
            if(c.courts[displayCourt].set3p2==30) c.courts[displayCourt].framep2s3 = 'redframe';

            // get rid of 3rd set if its unused
            if(c.courts[displayCourt].set3p1 == 0 && c.courts[displayCourt].set3p2 ==0) {
                c.courts[displayCourt].set3p1 = '';
                c.courts[displayCourt].set3p2 = '';
            }

            if(c.courts[displayCourt].set1p1 == undefined && c.courts[displayCourt].set1p2 == undefined) {
                c.courts[displayCourt].scoreBoardEnabled = false;
            } else {
                c.courts[displayCourt].scoreBoardEnabled = true;
            }

            //return c;
            //console.log(c.courts[displayCourt]);
        }
        return c;
    };
}

if (Meteor.isServer) {
    Meteor.startup(function () {

        // code to run on server at startup
        collectionApi = new CollectionAPI({ authToken: '97f0ad9e24ca5e0408a269748d7fe0a0' });
        collectionApi.addCollection(Courts, 'courts');
        collectionApi.addCollection(Connections, 'connections');
        collectionApi.addCollection(Control, 'control');
        collectionApi.start();
        //Connections.remove({});
        Control.remove({});
        Control.insert({value:"0",_id:"BackgroundTime"});

        //Control.insert({_id: "hostAddress", "value": ""});

        for(var i = 1; i <= 12; i++)
        {
            try {
                //Courts.insert({_id:"court"+i});
                Courts.insert({_id:"court"+i,"p1flag":"AAA","p2flag":"AAA","p1":Math.random().toString(36).substring(7),"p2":Math.random().toString(36).substring(7)}); // adding sample data
            }
            catch (e) {}
        }

        for(var i = 0; i < Connections.find().count(); i++)
        {
            if(Connections.find().fetch()[i]._id.substr(0,7)=="device-") {
                Connections.update({_id:Connections.find().fetch()[i]._id},{ $set: {color: ''}});
            }
        }
    });

    Meteor.methods({registerMonitor: function() {

        var clientAddress = this.connection.clientAddress;
        clientAddress = '-' + clientAddress.split('.')[3];

        console.log("boing");
        for(var i = 0; i < Connections.find().count(); i++)
        {
                console.log('give connection a color ' + Connections.find().fetch()[i]._id + ' -> ' + colors[i]);
                Connections.update({_id: Connections.find().fetch()[i]._id}, {$set: {color: colors[i]}});
        }

        var serverAddress = this.connection.httpHeaders["host"].replace(":3000","");  //TODO: replace 3000 to meteor port

        try { // TODO: does this really needs to be here?
            Control.insert({_id: "hostAddress", "value": serverAddress});
        }
        catch (e) {}
        return Meteor.http.call("GET","http://"+serverAddress+"/badminton-livescore-v2/output.php?debugid=Meteor" + clientAddress);

    } });

    Meteor.methods({getCourt: function() {
        var clientAddress = this.connection.clientAddress;
        clientAddress = '-' + clientAddress.split('.')[3];
//        console.log("runnig getcourt function" +clientAddress);
        // every connection needs to have a color for better visualisation


        try {
            return Connections.findOne({_id: "device-Meteor" + clientAddress}).court;
        }
        catch(e) {
            //Connections.update({_id:Connections.findOne({_id: "device-Meteor" + clientAddress})},{ $set: {court: 0}});
            Connections.insert({_id: "device-Meteor" + clientAddress, "court":"0", "color":""});
            console.log("new connection found -> 0");
            return 0;
        }
        //return Connections.findOne({_id: "device-192.168.2.104-Meteor"+clientAddress}).court;
    } });

    Meteor.methods({getDeviceId: function() {
        var clientAddress = this.connection.clientAddress;
        clientAddress = '-' + clientAddress.split('.')[3];

        return "device-Meteor" + clientAddress;
    } });

}
