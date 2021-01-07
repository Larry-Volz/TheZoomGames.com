/**

TODO: Sign-in screen (it's free to play - use your own zoom account)
    TODO: Put in user db, ask about news on new games checkbox
TODO: Start a game/join a game screen
    START GAME:
        TODO:  Start -> create board and do initial insert to db -> Put game number on screen for players
        TODO: Retrieve game ID to show for game-starter
    JOIN GAME:
        TODO: make a form to input game ID
        TODO: query db by game id -> populate player's board from db and adapt current code for play
TODO: Make an update function for when any player plays a question
    TODO: Active player pushes updated info to db
    TODO: DB pushes updates to other players or other players query db at interrupts for updates
    TODO: include scoring updates
TODO: SET UP current player function - can't click screen unless it's your turn(?)

TODO: When the user clicks the “Restart” button at the bottom of the page, it should load new categories and questions.

DEVELOPMENT OPTIONS FOR LATER
- add cool animation and graphics
- Make multi-player
- Add scoring - keeping the $$ in a database or local storage
- Other player(s) have to give you the point or no -- one buzzes in first the other
judges whether their answers were right or not.  One yes gives it.
- make a small space for ads (unobtrusive but fundable)
- switch to CSS and gradients to match other game

 */


 /* ----------------------------- ideas for later ----------------------------------*/
 
 //OPTIONAL OOP STRUCTURE IF DEVELOPED BEYOND PROTOTYPE/ONLINE MULTI-PLAYER
 //Class Game {} and do all within that class
    //format objects as game_date&time
    //property: id
    //property: date&time
    //array: playerList
    //method: CreatePlayer
        //player inherits game id
    //method: createGameArray

// class Round{
//     //later child of Game inherits date
//     //adds time?
//     //method: getquestion()
//     //method: verifyQuestionsValid
//     //method: createGameArray
//     constructor(date,...players){
//         this.date = date;
//         this.players = players; //how many?  how to handle?
//     }

    

 //create class: player
    //property: gamesWon (int)
    //property: moneyWon (int)
    //property: categoryIdsAsked (array) opt.
    //method set and get Winnings
    //method set and get GamesPlayed
    //
 /* --------------------------------------------------------------------------------------------------------*/


    /*
STRUCTURE from API:                         STRUCTURE I am making:  6 x  [{category: [
    {data: {title: foo,                                                           {q:foo, 
            id: foo,                                                               a:foo,
            clues_count:foo,                                                       v:foo}]},
            clues:                                                         {category: [
                [                                                                 {q:foo,
                {id:foo,                                                           a:foo,
                answer:foo,                                                        v:foo}]} 
                question:foo,                                               ... 
                value:foo,                                                  ]        
                airdate:foo}
                ]
            } 
    }

*/

//----------------------------------------------------------------------------------------------------------------------------------------

let RND;
let apiResponse;
let categories = {};
let qArray = [];
let getRND = () => Math.floor(Math.random()*18430);

//REMOVE FOR USE IN THEZOOMGAMES:
// getQuestions();


$(`#cat0`).html('<img src="images/Spinner-1s-200px.gif" id="spinner">');
$(`#cat1`).text("GETTING QUESTIONS");


// FUNCTION TO START ANOTHER GAME
$("#reload").on("click", ()=> {
        
    clearBoard();
    // setTimeout(()=>{
        
    // },500);

    getQuestions()
    .then(()=>{fillBoard(categories)})
    .then(()=>{gameLoop(categories)})
    
});




async function getQuestions() {
    let vAbbrev, aAbbrev, qAbbrev;
    let v, a, q;

    let validCategories = 0;
    let failureFlag = false;
    
        do{

        url = `https://jservice.io/api/category?id=${getRND()}`
        apiResponse = await axios.get(url)
        .then((res)=>{
            // console.log("res: ",res)
            return res;
        }).then((apiResponse)=>{

             //category = the key to each array-object
             let category = apiResponse.data.title;


            //array of clues (q's, a's and v's) are the VALUES to the key [category]
            //   array[key]    :   [{values}. {}...{}]
            categories[category] = apiResponse.data.clues;
            
            //DEBUGGING
            // console.log(`CATEGORY: ${category.toUpperCase()}`);

            for (let row = 0; row<5; row++){

                //adding scores as an upgrade
                // and using my own since theirs are inconsistent
                categories[category][row].value = (row+1)*200;

                //DEBUGGING
                // vAbbrev = categories[category][i].value;
                // qAbbrev = `Q: ${categories[category][i].question}`.slice(0,7);
                // aAbbrev = `A: ${categories[category][i].answer}`.slice(0,7);
                // console.log(`I: ${i}    q:${qAbbrev},     a:${aAbbrev},     v: ${vAbbrev}`); 

                q = categories[category][row].question;
                a = categories[category][row].answer;
                v = categories[category][row].value;

                //check for incomplete columns
                if (!q || !a || !v || !category || category === undefined || v===undefined || a===undefined || q===undefined) {
                    failureFlag = true;
                    // console.log(`***FALSY HERE ****`);
                }
            }
            
                if (!failureFlag){
                    validCategories++
                } else {
                    //reset counter/start over until we get 6 complete columns
                    validCategories = 0;
                    categories = [];
                    failureFlag = 0;
                }
            })

            

        } while (validCategories < 6)


    fillBoard(categories);

    insertSql(categories);

    gameLoop(categories);

    playAgain();
}



function insertSql(categories) {

    //insert CATEGORY TITLES into sql db
    const catArr = Object.keys(categories);

    //BRUTE FORCE PROGRAMMING UNTIL I CAN LEARN THE PROPER PHP SYNTAX TO DO IT IN A LOOP OR PASS ARRAYS

    $.post(
        'sql_initial_insert.php', 
        {
        cat0 : sqlStringCleaner(catArr[0]),
        cat1 : sqlStringCleaner(catArr[1]),
        cat2 : sqlStringCleaner(catArr[2]),
        cat3 : sqlStringCleaner(catArr[3]),
        cat4 : sqlStringCleaner(catArr[4]),
        cat5 : sqlStringCleaner(catArr[5]),
        
        cat0_row0_q : sqlStringCleaner(categories[catArr[0]][0].question),
        cat0_row1_q : sqlStringCleaner(categories[catArr[0]][1].question),
        cat0_row2_q : sqlStringCleaner(categories[catArr[0]][2].question),
        cat0_row3_q : sqlStringCleaner(categories[catArr[0]][3].question),
        cat0_row4_q : sqlStringCleaner(categories[catArr[0]][4].question),

        cat1_row0_q : sqlStringCleaner(categories[catArr[1]][0].question),
        cat1_row1_q : sqlStringCleaner(categories[catArr[1]][1].question),
        cat1_row2_q : sqlStringCleaner(categories[catArr[1]][2].question),
        cat1_row3_q : sqlStringCleaner(categories[catArr[1]][3].question),
        cat1_row4_q : sqlStringCleaner(categories[catArr[1]][4].question),

        cat2_row0_q : sqlStringCleaner(categories[catArr[2]][0].question),
        cat2_row1_q : sqlStringCleaner(categories[catArr[2]][1].question),
        cat2_row2_q : sqlStringCleaner(categories[catArr[2]][2].question),
        cat2_row3_q : sqlStringCleaner(categories[catArr[2]][3].question),
        cat2_row4_q : sqlStringCleaner(categories[catArr[2]][4].question),

        cat3_row0_q : sqlStringCleaner(categories[catArr[3]][0].question),
        cat3_row1_q : sqlStringCleaner(categories[catArr[3]][1].question),
        cat3_row2_q : sqlStringCleaner(categories[catArr[3]][2].question),
        cat3_row3_q : sqlStringCleaner(categories[catArr[3]][3].question),
        cat3_row4_q : sqlStringCleaner(categories[catArr[3]][4].question),

        cat4_row0_q : sqlStringCleaner(categories[catArr[4]][0].question),
        cat4_row1_q : sqlStringCleaner(categories[catArr[4]][1].question),
        cat4_row2_q : sqlStringCleaner(categories[catArr[4]][2].question),
        cat4_row3_q : sqlStringCleaner(categories[catArr[4]][3].question),
        cat4_row4_q : sqlStringCleaner(categories[catArr[4]][4].question),

        cat5_row0_q : sqlStringCleaner(categories[catArr[5]][0].question),
        cat5_row1_q : sqlStringCleaner(categories[catArr[5]][1].question),
        cat5_row2_q : sqlStringCleaner(categories[catArr[5]][2].question),
        cat5_row3_q : sqlStringCleaner(categories[catArr[5]][3].question),
        cat5_row4_q : sqlStringCleaner(categories[catArr[5]][4].question),

        cat0_row0_a : sqlStringCleaner(categories[catArr[0]][0].answer),
        cat0_row1_a : sqlStringCleaner(categories[catArr[0]][1].answer),
        cat0_row2_a : sqlStringCleaner(categories[catArr[0]][2].answer),
        cat0_row3_a : sqlStringCleaner(categories[catArr[0]][3].answer),
        cat0_row4_a : sqlStringCleaner(categories[catArr[0]][4].answer),

        cat1_row0_a : sqlStringCleaner(categories[catArr[1]][0].answer),
        cat1_row1_a : sqlStringCleaner(categories[catArr[1]][1].answer),
        cat1_row2_a : sqlStringCleaner(categories[catArr[1]][2].answer),
        cat1_row3_a : sqlStringCleaner(categories[catArr[1]][3].answer),
        cat1_row4_a : sqlStringCleaner(categories[catArr[1]][4].answer),

        cat2_row0_a : sqlStringCleaner(categories[catArr[2]][0].answer),
        cat2_row1_a : sqlStringCleaner(categories[catArr[2]][1].answer),
        cat2_row2_a : sqlStringCleaner(categories[catArr[2]][2].answer),
        cat2_row3_a : sqlStringCleaner(categories[catArr[2]][3].answer),
        cat2_row4_a : sqlStringCleaner(categories[catArr[2]][4].answer),

        cat3_row0_a : sqlStringCleaner(categories[catArr[3]][0].answer),
        cat3_row1_a : sqlStringCleaner(categories[catArr[3]][1].answer),
        cat3_row2_a : sqlStringCleaner(categories[catArr[3]][2].answer),
        cat3_row3_a : sqlStringCleaner(categories[catArr[3]][3].answer),
        cat3_row4_a : sqlStringCleaner(categories[catArr[3]][4].answer),

        cat4_row0_a : sqlStringCleaner(categories[catArr[4]][0].answer),
        cat4_row1_a : sqlStringCleaner(categories[catArr[4]][1].answer),
        cat4_row2_a : sqlStringCleaner(categories[catArr[4]][2].answer),
        cat4_row3_a : sqlStringCleaner(categories[catArr[4]][3].answer),
        cat4_row4_a : sqlStringCleaner(categories[catArr[4]][4].answer),

        cat5_row0_a : sqlStringCleaner(categories[catArr[5]][0].answer),
        cat5_row1_a : sqlStringCleaner(categories[catArr[5]][1].answer),
        cat5_row2_a : sqlStringCleaner(categories[catArr[5]][2].answer),
        cat5_row3_a : sqlStringCleaner(categories[catArr[5]][3].answer),
        cat5_row4_a : sqlStringCleaner(categories[catArr[5]][4].answer)
        },
        function( data ) {
            console.log( "Data Loaded: " + data );
        });

    
}


function sqlStringCleaner(str){
    str = str.replace(/\"/g, "''").replace(/\'/g, "''");
    return str;
}

   

function fillBoard(categories){
    let points;

    //for each column fill in category at the top
    const catArr = Object.keys(categories);

    


    // for (let i = 0; i <6; i++){

    //     // console.log(`CATEGORY ${i}: ${catArr[i]}`);

    //     //post category array to zoom_games_db_connections.php
    //     //make string literal into a string so it will work in $.post format
    //     str = `catArr[${i}]`;

    //     $.post(
    //         'sql_initial_insert.php', 
    //         { str : catArr[i]}, 
    //         function(response) {
    //             console.log("POSTING categoryArray - RESPONSE: ", response);
    //         }
    //     );

    // }// end of initial category insertion

    //for each cell fill in the values
    catArr.forEach((cat, idx) =>{


        

       
        //cat0 - cat5 are the header cells
        $(`#cat${idx}`).text(cat);
        for (let i=0; i< 6;i++){

            //check value
            // try{
            // $(`#${idx}${i}`).text(categories[element][idx]["value"]);
            // } catch {
            //     ////console.log("ERROR IN fillBoard at 177")
            //     return false;
            // }

            points = (idx+1)*200;
            // console.log(`categories[cat][idx].value = ${categories[cat][idx].value}`)
            try {
                // console.log(`cat-${i}:  ${cat}`)
                if (idx < 5) {
                    categories[cat][idx].value = points;
                }
            

        } catch(e) {
            console.log(categories[cat][idx]);
            console.log("cat:", cat);
            console.log("idx:", idx);
            console.log(`**** ERROR **** = ${e}`)
           // location.reload();
        }
            //print to board
            $(`#${idx}${i}`).text(points);
            // console.log($(`#${idx}${i}`));
            
        }
    });
}


 function gameLoop(){
    let $id, colId, colText, $rowId, cell, cellText, q, a, v;
    let [p1Score, p2Score, p3Score, p4Score] = [0,0,0,0];
    let boardCellCount = 0;

    //put event listeners on all the td's
   
    $(".table").on("click", (evt) => {

    let targetName = evt.target.nodeName;
    
    //don't react to table headings
    if (targetName != "TH"){
        $id = $(evt.target).attr('id');

        colId = `cat${$id.slice(1)}`; 
        colText = document.getElementById(colId).innerText;
        $rowId = $id.slice(0,1);
        
        cell = document.getElementById($id);
        cellText = cell.innerText;

        q = categories[colText][$rowId]["question"];
        a = categories[colText][$rowId]["answer"];
        v = parseInt(categories[colText][$rowId]["value"]);

        //TODO: check a for <i> and </i> and remove them
        
    
        //is the board cell == v?
        ////console.log(`cellText: ${cellText} v: ${v} \nq: ${q}\na: ${a}`);
        if (parseInt(cellText) == v){
            // cell.innerHTML = q;
            document.getElementById("qDisplay").innerText = q;
            document.getElementById("aDisplay").innerText = a;

            $('#qModal').modal('show');
            $('#aModal').modal('show');


            setTimeout(()=>{
                cell.style.fontSize = "xx-small;"
                cell.innerHTML = a;
            }, 1000);
            
            
            // cell.classList.add("text-primary");
            

            
    
        } 
        //else if (cellText == q){
        //     cell.innerHTML = a;
        // }

        $('#qModal').on('hidden.bs.modal', function (e) {
            document.getElementById("qDisplay").innerText = "";
        })
    }
    // $("#getAnswer").on("click", (cell, a) => {
    //     console.log(`cell: ${cell},  a: ${a}`);
    //     cell.innerHTML = a;
    //     // document.getElementById("qDisplay").innerText = q;
    //     // $('#qModal').modal('show');
        
    // });

    //is board full (boardCellcount = 30)? yes -> alert GAME OVER

    //new game button clicked? -> refresh pointseen
    
    //TODO: set up interactive score cards
    $("#player1").on("click", () =>{
        // ////console.log(`player1 clicked: earned ${v}`);
        p1Score += v;
        $("#p1-score").text(p1Score);
        v=0
        cell.classList.add("bg-success");
        cell.classList.add("text-light");
    });

    $("#player2").on("click", () =>{
        // ////console.log(`player2 clicked: earned ${v}`);
        p2Score += v;
        $("#p2-score").text(p2Score);
        v=0
        cell.classList.add("bg-warning");
        cell.classList.add("text-dark");
    });

    $("#player3").on("click", () =>{
        // ////console.log(`player3 clicked: earned ${v}`);
        p3Score += v;
        $("#p3-score").text(p3Score);
        v=0
        cell.classList.add("bg-danger");
        cell.classList.add("text-light");
    });

    $("#player4").on("click", () =>{
        // ////console.log(`player3 clicked: earned ${v}`);
        p4Score += v;
        $("#p4-score").text(p4Score);
        v=0
        cell.classList.add("bg-info");
        cell.classList.add("text-light");
    });

        
    });
    
  
   
}



 

function isGameOver(){
    //
}

function playAgain(){
    $("#reload").on("click", ()=> location.reload())
}

function clearBoard(){

    //THIS SAVES A LOT OF PAIN!!!
    categories = {};


    for (let k=2; k<6; k++){
        //cat0 - cat5 are the header cells
        // console.log(`#cat${i}`)
        $(`#cat${k}`).text("");
        // console.log(document.getElementById(`cat${i}`).innerText) // = "";
    }

    for (let j = 0; j <5; j ++){
        for (let k=0; k< 6;k++){
            $(`#${j}${k}`).text("")
            .removeClass("bg-warning bg-danger bg-success bg-info")
        }
    }

    }; //end of clearBoard()


// function processApiResponse(apiResponse){
//     //I think actually I'll want to feed it categories[]?
//     ////console.log(apiResponse);

//     let questions = apiResponse.data.clues;
//     questions.forEach((element, index) => {
//         createQuestionBlock(element, index);
        
//     });