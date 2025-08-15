// Board
let board;
let boardwidth = 360;
let boardheight = 640;
let context;

// Bird
let birdwidth = 34;
let birdheight = 24;
let birdx = boardwidth/8;
let birdy = boardheight/2;


let bird = {
  x: birdx,
  y: birdy,
  width: birdwidth,
  height: birdheight
};

// Pipe
let pipeArray =[]; // why we are using arrya because there can be multiple pipe so we need to track them that why we are using array
let pipeheight = 512; //  pipe image ki width/height ratio = 3072 pixel/384 pixel  = 1/8
let pipewidth = 64; // 64/512 = 1/8 what why we are using these number
let pipex = boardwidth;
let pipey = 0;
let toppipeimg ;
let bottompipeimg ;

// physics
let velocityX = -2; // pipe moving left speed
let velocityY = 0; // bird jump speed
let gravity = 0.4;
let gameover = false;
let score = 0;

window.onload = function () {
  board = document.getElementById("board");
  board.height = boardheight;
  board.width = boardwidth;
  context = board.getContext("2d"); // ✅ fixed case

  // Draw Flappy Bird
  //context.fillStyle = "green";
  //context.fillRect(bird.x, bird.y, bird.width, bird.height); // 💡 better to use bird object 

  //load image
  birdimage = new Image();
  birdimage.src = "./flappybird.png";
  birdimage.onload = function(){
    context.drawImage(birdimage,bird.x, bird.y, bird.width, bird.height);

  }
  toppipeimg = new Image();
  toppipeimg.src = "./toppipe.png";
  bottompipeimg = new Image();
  bottompipeimg.src = "./bottompipe.png";
  requestAnimationFrame(update);
  // now to we to create function that will generate pipe
  setInterval(placepipe , 1500); // every 1.5 second
  document.addEventListener("keydown" ,moveBird)
}
  function update(){
    requestAnimationFrame(update);
    if(gameover){
      return;
    }
    context.clearRect(0,0,board.width,board.height)
    // bird
    velocityY += gravity;
    //bird.y += velocityY;
    bird.y = Math.max(bird.y +velocityY , 0); // apply gravity to current bird.y limit to the bird to top of the canvas
    context.drawImage(birdimage,bird.x, bird.y, bird.width, bird.height);
    // we need to update pipe we are going to use array

    if(bird.y >board.height){
      gameover =true;
    }
    for(let i = 0 ; i<pipeArray.length ; i++)
    {
      let pipe = pipeArray[i];
      pipe.x += velocityX;
      context.drawImage(pipe.img , pipe.x , pipe.y , pipe.width , pipe.height)
      
      if(!pipe.passed && bird.x > pipe.x + pipe.width){
        score +=0.5; // if we use score +=1 then score will gonna update by 2 that why we have use 0.5 then it will gonna update by 1 == 0.5*2 = 1 because there is 2 pips
        pipe.passed  = true;
      }
      if(detectCollision(bird,pipe)){
        gameover = true;
      }

    }

    // clear pipe
    while(pipeArray.length>0 && pipeArray[0].x<-pipewidth){
      pipeArray.shift(); // it will remove first element form the array
    }

    context.fillStyle = "white";
    context.font = "45px sans-serif";
    context.fillText(score, 5 , 45);
    if(gameover){
      context.fillText("GAME OVER" ,5 ,90);
    }


} // update the frame of canvas and re draw over and over again basically its a loop for our game
function placepipe(){
  if(gameover){
    return;
  }
  let randompipe = pipey - pipeheight/4 - Math.random()*(pipeheight/2);
  let openingSpace = board.height/4;
  let topPipe ={
    img : toppipeimg,
    x : pipex,
    y : randompipe,
    width : pipewidth,
    height : pipeheight,
    passed : false

  }
  pipeArray.push(topPipe);
  // this placepipe function is called every 1.5 second and we place pipe and it will gonning to add new pipe in array

  let bottomPipe = {
    img: bottompipeimg,
    x : pipex,
    y : randompipe + pipeheight + openingSpace,
    width: pipewidth,
    height : pipeheight,
    passed:false
  }
  pipeArray.push(bottomPipe);

}
function moveBird(e){
  if(e.code == "Space" || e.code == "ArrowUp" || e.code == "keyX"){
    //jump
    velocityY = -6;

  // reset
  if(gameover){
    bird.y = birdy;
    pipeArray = [];
    score = 0;
    gameover = false;
  }
  }
}
function detectCollision(a , b){
   return a.x <b.x + b.width &&
          a.x + a.width > b.x &&
          a.y < b.y + b.height &&
          a.y + a.height > b.y;
}