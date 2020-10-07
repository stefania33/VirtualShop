<!DOCTYPE html>
<html lang="en">

<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<style>
.cover{
	width: 150px;
	height: auto;
}
</style>

<script>

			function emp(){
				document.querySelector("#listaAlbume").innerHTML=""
			}

			function afiseazaArtisti()
			{
				adresa="http://localhost:4000/artisti?callback=?"
				$.getJSON(adresa,function(raspuns)
				{
					$.each(raspuns,function(indice,artist)
					{
						continutDeAfisat="<li id='" + artist.id + "' class='list-group-item bg-light' onclick='emp(); afiseazaAlbum("+ artist.id +")'>"+ artist.nume +"</li>"
						$(continutDeAfisat).appendTo(document.querySelector("#listaArtisti"))
					}
					)
				}
				)
			}

			function afiseazaAlbum(idAlbum)
			{
				adresa="http://localhost:4000/albume?callback=?"
				$.getJSON(adresa,function(raspuns)
				{
					$.each(raspuns,function(indice,album)
					{
						if(idAlbum == album.artistid){
							continutDeAfisat="<div class='row p-2 my-2'><div class='col-md-4 m-auto'><h1 class='text-center mb-3'>" + album.nume + "</h1><button class='btn btn-success btn-sm btn-block my-2'>Sterge</button></div><div class='col-md-4 text-center'>	<img  class='rounded cover' src='" + album.img + "' alt='poza'></div><div class='col-md-4 m-auto'>	<h4 class='text-center'><strong>Pret:</strong></h4>	<h4 class='text-center'>" + album.pret + "$</h4>	<h4 class='text-center'><strong>Data aparitiei:</strong></h4><h4 class='text-center'>" + album.data_aparitie + "</h4></div></div>"
							$(continutDeAfisat).appendTo(document.querySelector("#listaAlbume"))
						}
					}
					)
				}
				)
			}

</script>



  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
  crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Bootstrap Theme</title>
</head>

<body class="bg-light">
	<div class="container">
		<button class="d-block btn btn-success btn-lg mt-5" onclick="afiseazaArtisti(); this.onclick=null;">Afiseaza Categorii</button>

		 <div class="row mt-5">

			<div class="col-md-3 border border-success rounded">
				<ul class="list-group list-group-flush" id="listaArtisti">

				</ul>
			</div>

			<div id="listaAlbume" class="col-md-9 border border-success rounded">
				
			</div>
		</div>

		<div class="border border-success my-3">
			<form class="my-3 px-3" action="">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-8">
						<div class="form-group">
							<input class="form-control" type="text" placeholder="Denumire">
						</div>
						<div class="form-group">
							<input class="form-control" type="text" placeholder="Pret">
						</div>
					</div>
					<div class="col-md-2 m-auto">
						<button class="btn btn-success btn-lg" type="submit">Submit</button>
					</div>
					<div class="col-md-1"></div>
				</div>
			</form>
		</div>

	</div>






  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
</body>

</html>