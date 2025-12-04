<form action="" method="get">
    <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." class="search-input" name="busqueda" value="<?php if(isset($_GET['busqueda'])){echo $_GET['busqueda'];}?>">
    <input type="submit" value="Buscar" name="btnBuscar">
</form>