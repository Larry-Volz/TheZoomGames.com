/*
THINGS TO DO
- do movement function where:
    - click 1: piece vanishes from board/curser turns into utfCode of piece
    - click 2: piece placed onto square chosen/curser turns back into arrow
- Add allowed/disallowed moves - objects, use ...spread to go through various moves
as an array to allow or disallow them
- create an undo function
- use localStorage to keep details "sticky"
- use database/login so 2 people can play long-distance
- do insult API
- do actual chess game API
*/

//GAME SET UP

function chessGame(){

    const wr_qs = {
                id : 'wr_qs',
                utfCode: '\u265C',
                color: 'white',
                name: 'rook',
                points: 5.1,
                status: "in play",
                visibility: "visible",
                rank: 0,
                file: 0}
    const wr_ks = {
                id: 'wr_ks',
                utfCode: '\u265C',
                color: 'white',
                name: 'rook',
                points: 5.1,
                status: "in play",
                visibility: "visible",
                rank: 0,
                file: 7}


    const wn_qs = {
                id: 'wn_qs',
                utfCode: '\u265E',
                color: 'white',
                name: 'knight',
                points: 3.2,
                status: "in play",
                visibility: "visible",
                rank:0,
                file:1}
    const wn_ks = {
                id: 'wn_ks',
                utfCode: '\u265E',
                color: 'white',
                name: 'knight',
                points: 3.2,
                status: "in play",
                visibility: "visible",
                rank:0,
                file: 6}

    const wb_qs = {
                id: 'wb_qs',
                utfCode: '\u265D',
                color: 'white',
                name: 'bishop',
                points: 3.33,
                status: "in play",
                visibility: "visible",
                rank: 0,
                file:2}

    const wb_ks = {
                id: 'wb_ks',
                utfCode: '\u265D',
                color: 'white',
                name: 'bishop',
                points: 3.33,
                status: "in play",
                visibility: "visible",
                rank:0,
                file:5 }


    const wq = {
                id: 'wq',
                utfCode: '\u265B',
                color: 'white',
                name: 'queen',
                points: 8.8,
                status: "in play",
                visibility: "visible",
                rank: 0,
                file: 3}

    const wk = {
                id: 'wk',
                utfCode: '\u265A',
                color: 'white',
                name: 'king',
                points: 4,
                status: "in play",
                visibility: "visible",
                rank: 0,
                file: 4}

    const wpa = {
                id: 'wpa',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:0}
    const wpb = {
                id: 'wpb',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:1}
    const wpc = {
                id: 'wpc',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:2}
    const wpd = {
                id: 'wpd',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:3}
    const wpe = {
                id: 'wpe',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:4}
    const wpf = {
                id: 'wpf',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:5}
    const wpg = {
                id: 'wpg',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:6}
    const wph = {
                id: 'wph',
                utfCode: '\u265F',
                color: 'white',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:1,
                file:7}



    const br_qs = { 
                id: 'br_qs',
                utfCode: '\u265C',
                color: 'black',
                name: 'rook',
                points: 5.1,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:0}

    const br_ks = { 
                id: 'br_ks',
                utfCode: '\u265C',
                color: 'black',
                name: 'rook',
                points: 5.1,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:7}


    const bn_qs = {
                id: 'bn_qs',
                utfCode: '\u265E',
                color: 'black',
                name: 'knight',
                points: 3.2,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:1 }

    const bn_ks = {
                id: 'bn_ks',
                utfCode: '\u265E',
                color: 'black',
                name: 'knight',
                points: 3.2,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:6 }


    const bb_qs = {
                id: 'bb_qs',
                utfCode: '\u265D',
                color: 'black',
                name: 'bishop',
                points: 3.33,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:2}

    const bb_ks = {
                id: 'bb_ks',
                utfCode: '\u265D',
                color: 'black',
                name: 'bishop',
                points: 3.33,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:5 }


    const bq = {
                id: 'bq',
                utfCode: '\u265B',
                color: 'black',
                name: 'queen',
                points: 8.8,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:3 }

    const bk = {
                id: 'bk',
                utfCode: '\u265A',
                color: 'black',
                name: 'king',
                points: 4,
                status: "in play",
                visibility: "visible",
                rank:7,
                file:4}

    const bpa = {
                id: 'bpa',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:0} 
    const bpb = {
                id: 'bpb',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:1
            } 
    const bpc = {
                id: 'bpc',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:2} 
    const bpd = {
                id: 'bpd',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:3} 
    const bpe = {
                id: 'bpe',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:4} 
    const bpf = {
                id: 'bpf',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:5} 
    const bpg = {
                id: 'bpg',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:6} 
    const bph = {
                id: 'bph',
                utfCode: '\u265F',
                color: 'black',
                name: 'pawn',
                points: 1,
                status: "in play",
                visibility: "visible",
                rank:6,
                file:7} 
                

    // 0=empty, 1=touched but not moved
    //Note: those are OBJECT VARIABLES in the array NOT TEXT!
    //so they directly load in the object each one represents!
    const rankAndFile = [
        [wr_qs,wn_qs,wb_qs,wq,wk,wb_ks,wn_ks,wr_ks], //0,0 - 0,7
        [wpa,wpb,wpc,wpd,wpe,wpf,wpg,wph],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [bpa,bpb,bpc,bpd,bpe,bpf,bpg,bph],
        [br_qs,bn_qs,bb_qs,bq,bk,bb_ks,bn_ks,br_ks], //7,0 - 7,7
    ];

    // const divPositions = [
    //     ['#a1','#b1','#c1','#d1','#e1','#f1','#g1','#h1'], //0,0 - 0,7
    //     ['#a2','#b2','#c2','#d2','#e2','#f2','#g2','#h2'],
    //     ['#a3','#b3','#c3','#d3','#e3','#f3','#g3','#h3'],
    //     ['#a4','#b4','#c4','#d4','#e4','#f4','#g4','#h4'],
    //     ['#a5','#b5','#c5','#d5','#e5','#f5','#g5','#h5'],
    //     ['#a6','#b6','#c6','#d6','#e6','#f6','#g6','#h6'],
    //     ['#a7','#b7','#c7','#d7','#e7','#f7','#g7','#h7'],
    //     ['#a8','#b8','#c8','#d8','#e8','#f8','#g8','#h8'], //7,0 - 7,7
    // ];

    const letters = "abcdefgh";
    let idCode;
    let currentPiece=0;
    const table = document.querySelector("table");
    // let allVisable = true;

    let clickedYX = [9,9];
    let lastClickedYX = [9,9];
    let pieceObj = 0;
    let lastPieceObj = 0;
    let pieceTouched = false;
    let touchedId ="";
    let position = "";

    // console.log(`rankAndFile: ${rankAndFile[0][0]}`);

    function drawBoard () {
        for (let rank = 0; rank < 8; rank++) {
            for (let fil = 0; fil < 8; fil++) {
                idCode = "#"+letters[fil]+(rank+1);
                // console.log(idCode);
                // console.log(`id: ${idCode}, rank: ${rank}, file: ${fil}`);

                currentPiece = rankAndFile[rank][fil];

                board = document.querySelector(idCode);
                board.innerHTML = (currentPiece) ? currentPiece.utfCode : '&nbsp';
                board.style.color = currentPiece.color;
                board.style.fontSize = "1.4rem";
                board.style.textAlign = "center";

                // console.log(`currentPiece.color: ${currentPiece.color}`)

                
                
                
            }

        }
    };

    drawBoard();


    //----------------------------------------------------------------- GAME LOOP ----------------------------------
    table.addEventListener('click', function(event) {

        position = event.target.id;
        clickedYX = convertIdToRF(position); //returns an array with 2 variables, file and rank
        pieceObj = getPiece (clickedYX); //gets the object of the piece at that position in array

        if (!pieceTouched && pieceObj) {
            //if it wasn't touched before indicated it has been now and set
            //touchedId - a y,x string (?)
            touchedId = setTouchedPiece(clickedYX);
            console.log(`touchedId = ${touchedId}`);

            //set last piece as this coordinate in case we can't move
            lastPieceObj = pieceObj;
            lastClickedYX = clickedYX;
            
            //highlight piece/change it's color
            let temp = pieceObj.color;
            pieceObj.color = "red";

            drawBoard();

            pieceObj.color = temp;
            
        } else if (pieceTouched) {
            //means this is the 2nd click so change it back
            pieceTouched=false;
            //if it has been touched will will move it - later add logic about
            //whether it is a legal move or not/if there is another piece there
            
            //change object's color back, update the array with new position
            //unless illegal move and then returns without changing the board
            setPiece(touchedId, clickedYX, pieceObj);

            
            //replaces object with a nbsp in array
            // removePiece(touchedId);

            drawBoard();
        }
        
        //show position on screen
        displayPosition(pieceObj);

        // console.log("piece is:", pieceObj);

    
    
        //highlight piece

        // movePiece(event);
    });

    //----------------------------------------------------------------- GAME LOOP ----------------------------------


    // function movePiece(event){
        
    //     let space = event.target.id.innerText;

    //     if (allVisable && space != '&nbsp'){
            
    //         //it means a piec was just clicked to move
    //         //eventually do an animation to make it stick to the curser here
    //         //in the meantime turn it into a ? waiting to see where they are moving it to
    //         // space = "To?";

    //         console.log('piece here');
    //     } else {
    //         //stuff
    //     }

    //     drawBoard();
    // }

    //convert the div id returned to the rank and file number for the position array
    convertIdToRF = (eId) =>  [letters.indexOf(eId.substr(0,1)), (eId.slice(1)-1)];

    // takes array with fil and rank values returns piece object
    getPiece = (fAndR) => rankAndFile[fAndR[1]][fAndR[0]];

    //displays position and identity of just clicked pieceObj
    function displayPosition(pieceObj){
        const outPut = document.querySelector('#position');
        outPut.innerText = (pieceObj) ? `${pieceObj.color} ${pieceObj.name} at ${position} to? ` : "\u00a0";
    }

    //pass rank and file as a 2-element array
    let setTouchedPiece = (clickedYX) => {
        // rankAndFile[fAndR[1]][fAndR[0]] = 1;
        pieceTouched = true;
        return clickedYX;
    }

    function setPiece(yxFrom, yxTo, movingPiece) {

        if (freeOfFriends(yxTo[1], yxTo[0], movingPiece) 
            && isOnBoard(yxTo[1], yxTo[0])) {

            let fromId = rankAndFile[yxFrom[1]][yxFrom[0]];

            rankAndFile[yxTo[1]][yxTo[0]] = {...fromId};
            console.log(`moved to ${yxTo[1]}, ${yxTo[0]}`);

            rankAndFile[yxFrom[1]][yxFrom[0]] = 0
        }
    }

    function freeOfFriends(y,x,pieceObj){
        let squareContents =rankAndFile[y][x];
        let {id, name, color} = squareContents;
        if (lastPieceObj.color === color) {
            console.log(`you are ${pieceObj.color} and they are ${color}`)
            console.log(`YOU CANNOT MOVE THERE! ${y}, ${x} contains a ${color} ${name}`);
            return false;
        }
        return true;
    }

    let isOnBoard = (y,x,) => (y<8 && x<8);

};
