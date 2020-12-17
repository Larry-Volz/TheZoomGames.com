/**

TODO: When the user clicks the “Restart” button at the bottom of the page, it should load new categories and questions.

TODO: try-catch block in case can't connect. 

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









async function getQuestions() {
    let vAbbrev, aAbbrev, qAbbrev;
    let v, a, q;

    let validCategories = 0;
    let failureFlag = false;
    
        do{
            try {
            apiResponse = await axios.get(`https://jservice.io/api/category?id=${getRND()}`);
            } catch(e) {
                console.log(`ERROR THROWN at apiResponse e= ${e}`);
            }
            
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
        

        } while (validCategories < 6)

        console.log(categories);


    fillBoard(categories);

    gameLoop(categories);

    playAgain();
}



   

function fillBoard(categories){
    let scr;

    //for each column fill in category at the top
    ////console.log('OBJECT KEYS')
    const catArr = Object.keys(categories);
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

            scr = (idx+1)*200;
            // console.log(`categories[cat][idx].value = ${categories[cat][idx].value}`)
            try {
                // console.log(`cat-${i}:  ${cat}`)
                if (idx < 5) {
                    categories[cat][idx].value = scr;
                }

        } catch(e) {
            console.log(categories[cat][idx]);
            console.log("cat:", cat);
            console.log("idx:", idx);
            console.log(`**** ERROR **** = ${e}`)
           // location.reload();
        }
            //print to board
            $(`#${idx}${i}`).text(scr);
            console.log($(`#${idx}${i}`));
            
        }
    });
}


 function gameLoop(categories){
    let $id, colId, colText, $rowId, cell, cellText, q, a, v;
    let p1Score = 0;
    let p2Score = 0;
    let p3Score = 0;
    let boardCellCount = 0;

    //put event listeners on all the td's
    $(".table").on("click", (evt) => {
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

    // $("#getAnswer").on("click", (cell, a) => {
    //     console.log(`cell: ${cell},  a: ${a}`);
    //     cell.innerHTML = a;
    //     // document.getElementById("qDisplay").innerText = q;
    //     // $('#qModal').modal('show');
        
    // });

    //is board full (boardCellcount = 30)? yes -> alert GAME OVER

    //new game button clicked? -> refresh screen
    
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
        
    });
    
  
   
}



 

function isGameOver(){
    //
}

function playAgain(){
    $("#reload").on("click", ()=> location.reload())
}



// function processApiResponse(apiResponse){
//     //I think actually I'll want to feed it categories[]?
//     ////console.log(apiResponse);

//     let questions = apiResponse.data.clues;
//     questions.forEach((element, index) => {
//         createQuestionBlock(element, index);
        
//     });