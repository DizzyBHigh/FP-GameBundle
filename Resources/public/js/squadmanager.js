//set-up player spots as empty to start with
$(document).ready(function () {


    var squadSettings = {
        "pmax": {
            "QB": 1,
            "RB": 2,
            "WR": 2,
            "TE": 1,
            "K": 1,
            "FLEX": 1,
            "DEF": 1,
            "SALARY": 50000
        },
        "pcount": {
            "QB": 0,
            "RB": 0,
            "WR": 0,
            "TE": 0,
            "K": 0,
            "FLEX": 0,
            "DEF": 0,
            "SALARY": 0
        }
    };

    var squadPlayers = {
        'qb': null,
        'rb1': null,
        'rb2': null,
        'wr1': null,
        'wr2': null,
        'te': null,
        'k': null,
        'flex': null,
        'def': null
    };

//var undraftPlayerBtn  = $('div').addClass('btn btn-sm btn-warning undraft-player squadBtn');
//var draftPlayerBtn  = '<div class="btn btn-sm btn-success draft-player">+</div>';

    $('body').delegate('.draft-player', 'click', function () {
        //var tr = $(this).closest('tr');
        var player = $(this).data('player');
        console.log(player);
        var result = addPlayerToSquad(player);
        var msgType = '';
        if (!result['status']) {
            msgType = 'error';
        } else {
            msgType = 'success';
        }
        $(this).notify(result['message'], msgType, {
            position: 'left middle',
            elementPosition: 'left middle',
            style: 'bootstrap',
            autoHide: true,
            autoHideDelay: 750
        });
        if (result['status']) {
            $(this).removeClass('btn-success draft-player').addClass('btn-warning undraft-player').text('-');
        }
    });

    $('body').delegate('.undraft-player', 'click', function () {
        //alert('undrafting player
        var player = $(this).data('player');
        var result = removePlayerFromSquad(player);
        if (result['status']) {
            msgType = 'error';
        } else {
            var msgType = 'success';
        }
        $(this).notify(result['message'], msgType, {
            position: 'left middle',
            elementPosition: 'left middle',
            style: 'bootstrap',
            autoHide: true,
            autoHideDelay: 750
        })
        var mainBtn = '#draftBtn-' + player['player']
        $(mainBtn).removeClass('btn-warning undraft-player').addClass('btn-success draft-player').text('+');
        //$(this).remove();
    });

    var checkSalary = function (player) {
        var salaryMax = squadSettings.pmax['SALARY'];
        var thisSalary = player['salary'];
        var currentTotal = squadSettings.pcount["SALARY"];
        var newTotal = currentTotal + thisSalary;
        if (newTotal >= salaryMax) {
            return {'status': false, 'message': 'You dont have enough money to draft this player!'};
        } else {
            return {'status': true, 'message': 'You have funds Avaliable to draft player'}
        }
    };

    var addSalary = function (player) {
        squadSettings.pcount["SALARY"] = squadSettings.pcount["SALARY"] + player['salary'];
        displaySalaryLeft()
    };

    var removeSalary = function (player) {
        squadSettings.pcount["SALARY"] = squadSettings.pcount["SALARY"] - player['salary'];
        displaySalaryLeft()
    };

    var displaySalaryLeft = function () {
        var fundsLeft = squadSettings.pmax["SALARY"] - squadSettings.pcount["SALARY"];
        $('#salaryLeft').text('$' + fundsLeft);
    };

    var addPlayerToSquad = function (player) {
        var position = player['position'];
        var fundCheck = checkSalary(player);
        if (fundCheck['status']) {
            if (isPosFree(position)) {
                var currentPos = addPos(position);
                //console.log('currentPos = '+ currentPos);
                var hiddenRef = '#contestEntry_' + currentPos;

                squadPlayers[currentPos] = player['playerID'];
                $(hiddenRef).val(player['playerID']);
                setSquadRow(player, false);
                addSalary(player);
                return {'status': true, 'message': 'Added ' + player['shortName'] + ' as ' + currentPos};
            }
            if (!isPosFree(position)) {
                if (isPlayerFlex(player) && isPosFree('FLEX')) {

                    squadSettings.pcount['FLEX']++;
                    squadPlayers['flex'] = player['playerID'];
                    hiddenRef = '#contestEntry_flex';
                    $(hiddenRef).val(player['playerID']);
                    setSquadRow(player, true);
                    addSalary(player);
                    return {'status': true, 'message': 'Added ' + player['shortName'] + ' as Flex'};
                }
            }

            return {'status': false, 'message': player['position'] + ' is Filled'};
        } else {
            return fundCheck;
        }
    };

    var removePlayerFromSquad = function (player) {
        console.log('removing player', player);
        var position = player['position'];
        var posRef = val2key(player['playerID'], squadPlayers);
        var hiddenRef = '#contestEntry_' + posRef;
        console.log(player);
        console.log('posRef: ' + posRef + ' position (actual): ' + position + ' hiddenRef' + hiddenRef);
        if (posRef == 'flex') {
            //update count for flex
            squadSettings.pcount['FLEX']--;
        } else {
            //update Count for position
            squadSettings.pcount[position]--;
        }
        $(hiddenRef).val('');
        clearSquadRow(posRef);
        removeSalary(player);
        squadPlayers[posRef] = null;
        var mainBtn = '#draftBtn-' + player['playerID']
        $(mainBtn).removeClass('btn-warning undraft-player').addClass('btn-success draft-player').text('+');
        return {'status': true, 'message': player['shortName'] + ' ' + position + ' removed from ' + posRef};
    };

    var val2key = function (value, obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                if (obj[prop] === value)
                    return prop;
            }
        }
        return false;
    };


    var isPlayerFlex = function (player) {
        switch (player['position']) {
            case 'WR':
            case 'TE':
            case 'RB':
            case 'FLEX':
                return true;
                break;
            case 'K':
            case 'QB':
            case 'DEF' :
                return false;
                break;
        }
    };

    var getPosCount = function (position) {
        return squadSettings.pcount[position];
    };

    var isPosFree = function (position) {
        return squadSettings.pmax[position] > squadSettings.pcount[position];
    };

    var posHasPlayer = function (position) {
        return squadSettings.pcount[position] > 0;
    };

    var addPos = function (position) {
        //check if position is free
        if (isPosFree(position)) {
            squadSettings.pcount[position]++;
            if (hasMultipleSlots(position)) {
                //check which slot is free....
                return getFreeSlot(position);
            } else {
                return position.toLowerCase();
            }
        } else return false;
    };

    var removePos = function (position) {
        //update position count
        if (posHasPlayer(position)) {
            squadSettings.pcount[position]--;
            return true
        } else return false;
    };

    var setSquadRow = function (player, flex) {
        //get position from playerID
        var posRef = getAssignedPos(player);
        console.log('assignedPos: ' + posRef);
        var newBtn = $('<div/>', {
            text: '-',
            class: 'btn btn-sm btn-warning undraft-player squadBtn'
        });
        newBtn.attr('data-player', JSON.stringify(player));
        console.log(newBtn);
        $('#' + posRef + '-name').html(player['shortName']);
        $('#' + posRef + '-team-opp').html(player['team'] + ' @ ' + player['opponent']);
        $('#' + posRef + '-opprank').html(player['opponentRank']);
        $('#' + posRef + '-ffpg').html(player['opponentPositionRank']);
        $('#' + posRef + '-salary').html(player['salary']);
        $('#' + posRef + '-tools').append(newBtn);

        //$('#'+posRef).attr("data-player", player);
    };

    var clearSquadRow = function (posRef) {
        $('#' + posRef + '-name').html('');
        $('#' + posRef + '-team-opp').html('');
        $('#' + posRef + '-opprank').html('');
        $('#' + posRef + '-ffpg').html('');
        $('#' + posRef + '-salary').html('');
        $('#' + posRef + '-tools').html('');
        //$('#'+posRef+'-tools').attr('data-player', '');
    };

    var getBasePos = function (player) {
        switch (player['position']) {
            case 'DEF':
            case 'QB':
            case 'TE':
            case 'K':
            case 'FLEX':
                return player['position'].toLowerCase();
                break;
            case 'WR':
            case 'RB':
                return player['position'].toLowerCase() + squadSettings.pcount[player['position']];
                break;
        }
    };

    var getAssignedPos = function (player) {
        return val2key(player['playerID'], squadPlayers);
    };

    var getPlayerData = function (playerID) {
        var playerData = $('#player-' + playerID).data('player');
        console.log('playerData: ' + playerData);
        return playerData;
    };

    var hasMultipleSlots = function (position) {
        return squadSettings.pmax[position] > 1;
    };

    var getFreeSlot = function (position) {
        var freeSlot = position.toLowerCase();

        for (var i = 1; i <= squadSettings.pmax[position]; i++) {
            freeSlot = position.toLowerCase() + i;
            if (squadPlayers[freeSlot] == null) {
                console.log('slot to add player: ' + freeSlot);
                break;
            }
        }
        return freeSlot
    }

    var getPosKeys = function () {
        var keys = [];
        for (var key in squadPlayers) {
            if (squadPlayers.hasOwnProperty(key)) {
                keys.push(key);
            }
        }
        return keys;
    }

    var populateEntry = function (player, element) {
        console.log('adding:' + element);
        squadPlayers[element] = player['playerID'];
        if (element === 'flex') {
            squadSettings.pcount['FLEX']++;
            setSquadRow(player, true);
        } else {
            squadSettings.pcount[player['position'].toUpperCase()]++;
            setSquadRow(player, false);
        }
        addSalary(player);

        var mainBtn = '#draftBtn-' + player['playerID'];
        $(mainBtn).removeClass('btn-success draft-player').addClass('btn-warning undraft-player').text('-');
        return {'status': true, 'message': 'Added ' + player['shortName'] + ' as ' + element};
    };

    var initSquad = function () {
        var keys = getPosKeys();
        console.log(keys);
        keys.forEach(function (element) {
            var formRef = '#contestEntry_' + element;
            console.log(formRef);
            var playerID = $(formRef).val();
            if (playerID) {
                //console.log({'playerID': playerID});
                var btnRef = '#draftBtn-' + playerID;
                console.log({'btnRef': btnRef});
                var player = $(btnRef).data("player");

                console.log('populating player');
                populateEntry(player, element);
            }
        }, this);
    };
//console.log(getPosKeys());
    initSquad();

});