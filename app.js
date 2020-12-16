const chessModule = `<div class = "box">
<h1 class = "text-center">Cheeky Chess</h1>
    <table class ="content">
        <thead><div id="position">&nbsp;</div></thead>
        <tr>
            <td><div id = "a8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b8" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d8" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f8"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h8" class="darkSquares">&nbsp;</div></td>
        </tr>

        <tr>
            <td><div id = "a7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b7" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d7" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f7" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h7" class="lightSquares">&nbsp;</div></td>
        </tr>
        
        <tr>
            <td><div id = "a6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b6" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d6" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f6"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h6" class="darkSquares">&nbsp;</div></td>
        </tr>
    
        <tr>
            <td><div id = "a5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b5" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d5" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f5" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h5" class="lightSquares">&nbsp;</div></td>
        </tr>

        <tr>
            <td><div id = "a4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b4" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d4" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f4"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h4" class="darkSquares">&nbsp;</div></td>
        </tr>
    
        <tr>
            <td><div id = "a3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b3" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d3" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f3" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h3" class="lightSquares">&nbsp;</div></td>
        </tr>

        <tr>
            <td><div id = "a2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b2" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d2" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f2"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h2" class="darkSquares">&nbsp;</div></td>
        </tr>
        <tr>
            <td><div id = "a1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b1" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d1" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f1" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h1" class="lightSquares">&nbsp;</div></td>
        </tr>
    </table>
</div>`;

const jeopardyModule = `
<div class="container mt-2">
        <div class = "row">
            <h1 class = "display-4 text-light m-2">Jeopardy</h1>"
        </div>
        <div class="row">
            <table class="table table-dark bg-primary m-2">
                <thead>
                    <tr>
                        <th scope = "col" id = "cat0"></th>
                        <th scope = "col" id = "cat1"></th>
                        <th scope = "col" id = "cat2"></th>
                        <th scope = "col" id = "cat3"></th>
                        <th scope = "col" id = "cat4"></th>
                        <th scope = "col" id = "cat5"></th>
                    </tr>
                    <tr id="row0" class = "text-warning">
                        <td id="00"></td>
                        <td id="01"></td>
                        <td id="02"></td>
                        <td id="03"></td>
                        <td id="04"></td>
                        <td id="05"></td>
                    </tr>
                    <tr id="row1" class = "text-warning">
                        <td id="10"></td>
                        <td id="11"></td>
                        <td id="12"></td>
                        <td id="13"></td>
                        <td id="14"></td>
                        <td id="15"></td>
                    </tr>
                    <tr id="row2" class = "text-warning">
                        <td id="20"></td>
                        <td id="21"></td>
                        <td id="22"></td>
                        <td id="23"></td>
                        <td id="24"></td>
                        <td id="25"></td>
                    </tr>
                    <tr id="row3" class = "text-warning">
                        <td id="30"></td>
                        <td id="31"></td>
                        <td id="32"></td>
                        <td id="33"></td>
                        <td id="34"></td>
                        <td id="35"></td>
                    </tr>
                    <tr id="row4"  class = "text-warning">
                        <td id="40"></td>
                        <td id="41"></td>
                        <td id="42"></td>
                        <td id="43"></td>
                        <td id="44"></td>
                        <td id="45"></td>
                    </tr>

                </thead>
            </table>
        </div>
        <div class="row justify-content-center">
            <div id = "player1" class="col-3 bg-success m-2  border rounded">Player 1
                <p>Score: <span id="p1-score">0</span></p>
            </div>
            <div id = "player2" class="col-3 bg-warning m-2  border rounded">Player 2
                <p>Score: <span id="p2-score">0</span></p>
            </div>
            <div id = "player3" class="col-3 bg-danger m-2  border rounded">Player 3
                <p>Score: <span id="p3-score">0</span></p>
            </div>
        </div>
        <div class="row justify-content-center">
            <button class = " btn btn-info border rounded mt-5" id = "reload">Restart Game</button>
        </div>
    </div>
    
        <!-- Modal -->
    <div class="modal fade bg-dark" id="qModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div id="qDisplay" class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button id = "getAnswer" type="button" class="btn btn-success" data-dismiss="modal">Answer</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="aModal"  data-backdrop = "false" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div id="aDisplay" class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button id = "getAnswer" type="button" class="btn btn-success" data-dismiss="modal">Done</button>
            </div>
        </div>
        </div>
    </div>
`;

window.onload = function() {

    $("#jeopardy-game").on("click", () => {
        console.log("clicked")
        document.getElementById("game-area").innerHTML = jeopardyModule;
        // chessGame();
        getQuestions();
    })


    $("#chess-game").on("click", () => {
        console.log("clicked")

        document.getElementById("game-area").innerHTML = chessModule;
        // chessGame();
    })















  }//end of onload - keep all jquery here







