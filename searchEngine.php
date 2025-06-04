<?php
    require_once('database.php');
    $breedsText = $_POST['breedText'];
    $genesText = $_POST['geneText'];
    $alterationsText = $_POST['alterationsText'];
    $traitsText = $_POST['traitText'];
    if ($breedsText != ""){
        $breeds = explode(";", $breedsText);
    }
    else{
        $breeds = [];
    }
    if ($genesText != ""){
        $genes = explode(";", $genesText);
    }
    else{
        $genes = [];
    }
    if ($alterationsText != ""){
        $alterations = explode(";", $alterationsText);
    }
    else{
        $alterations = [];
    }
    if ($traitsText != ""){
        $traits = explode(";", $traitsText);
    }
    else{
        $traits = [];
    }
    
   
    
    
    $breedCount = count($breeds);
    $geneCount = count($genes);
    $altCount = count($alterations);
    $traitCount = count($traits);

    for ($i = 0; $i < $breedCount; $i++){
        $breeds[$i] = trim($breeds[$i]);
    }
    for ($i = 0; $i < $geneCount; $i++){
        $genes[$i] = trim($genes[$i]);
    }
    for ($i = 0; $i < $altCount; $i++){
        $alterations[$i] = trim($alterations[$i]);
    }
    for ($i = 0; $i < $traitCount; $i++){
        $traits[$i] = trim($traits[$i]);
    }
    if (($key = array_search("", $breeds)) !== false) {
        unset($breeds[$key]);
        $breedCount--;
    }
    if (($key = array_search("", $genes)) !== false) {
        unset($genes[$key]);
        $geneCount--;
    }
    if (($key = array_search("", $alterations)) !== false) {
        unset($alterations[$key]);
        $altCount--;
    }
    if (($key = array_search("", $traits)) !== false) {
        unset($traits[$key]);
        $traitCount--;
    }


    //  Case 1 - Search for ----Breed----
    if ($breedCount > 0 && $geneCount == 0 && $altCount == 0 && $traitCount == 0){
        $sql = 'SELECT * FROM Breed WHERE ';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . "s";
            if ($i == 0){
                $sql = $sql . 'BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        $result = selectFromSQL($types, $breeds, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['ID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';

    }
    
    //  Case 2 - Search for ----Gene----
    if ($breedCount == 0 && $geneCount > 0 && $altCount == 0 && $traitCount == 0){
        $sql = 'SELECT * FROM Gene WHERE ';
        $types = "";
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . "s";
            if ($i == 0){
                $sql = $sql . 'GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        $result = selectFromSQL($types, $genes, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Gene</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Gene?id=' . $row['ID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 3 - Search for ----Alteration----
    if ($breedCount == 0 && $geneCount == 0 && $altCount > 0 && $traitCount == 0){
        $sql = 'SELECT * FROM Alteration WHERE ';
        $types = "";
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . "s";
            if ($i == 0){
                $sql = $sql . 'AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        $result = selectFromSQL($types, $alterations, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Alteration?id=' . $row['ID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 4 - Search for ----Trait----
    if ($breedCount == 0 && $geneCount == 0 && $altCount == 0 && $traitCount > 0){
        $sql = 'SELECT * FROM Trait WHERE ';
        $types = "";
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . "s";
            if ($i == 0){
                $sql = $sql . 'TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $result = selectFromSQL($types, $traits, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Trait</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Trait?id=' . $row['ID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 5 - Search for ----Breed----Trait----
    if ($breedCount > 0 && $geneCount == 0 && $altCount == 0 && $traitCount > 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, T.ID AS TraitID, T.TraitDescription, "Inherent to Breed" AS Association, NULL AS AltID 
                FROM Breed B
                LEFT JOIN BreedTrait BT ON BT.BreedID = B.ID
                LEFT JOIN Trait T ON T.ID = BT.TraitID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ')';
        $sql = $sql . ' UNION (SELECT B.ID, B.BreedName, T.ID, T.TraitDescription, CONCAT("Through DNA Alteration: ", A.AlterationDesc) AS Association, A.ID AS AlterationID
                        FROM Breed B
                        LEFT JOIN AssociatedBreed AB ON AB.BreedID = B.ID
                        LEFT JOIN AssociatedTraits ATs ON ATs.AlterationID = AB.AlterationID
                        LEFT JOIN Trait T ON ATs.TraitID = T.ID
                        LEFT JOIN Alteration A ON AB.AlterationID = A.ID
                        WHERE (';
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . '));';
        $arr = array_merge($breeds, $traits, $breeds, $traits);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Trait</th>
                <th scope="col">Association Type</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['Association'], ENT_QUOTES, 'UTF-8');
            $aTagBegin = "";
            $aTagEnd = "";
            if ($alterationDesc != "Inherent to Breed"){
                $aTagBegin =  '<a href="Alteration?id=' . $row['AltID'] . '">';
                $aTagEnd = '</a>';
            }
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                    <td>' . $aTagBegin . $alterationDesc . $aTagEnd . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 6 - Search for ----Breed----Gene----
    if ($breedCount > 0 && $geneCount > 0 && $altCount == 0 && $traitCount == 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, G.ID AS GeneID, G.GeneName, CONCAT("Through DNA Alteration: ", A.AlterationDesc) AS Association, A.ID AS AlterationID
                FROM Breed B
                LEFT JOIN AssociatedBreed AB ON AB.BreedID = B.ID
                LEFT JOIN Alteration A ON A.ID = AB.AlterationID
                LEFT JOIN AssociatedGene AG ON A.ID = AG.AlterationID
                LEFT JOIN Gene G ON AG.GeneID = G.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($breeds, $genes);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Gene</th>
                <th scope="col">Association Type</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['Association'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 7 - Search for ----Breed----Alteration----
    if ($breedCount > 0 && $geneCount == 0 && $altCount > 0 && $traitCount == 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, A.ID AS AlterationID, A.AlterationDesc 
                FROM Breed B
                LEFT JOIN AssociatedBreed AB ON B.ID = AB.BreedID
                LEFT JOIN Alteration A ON AB.AlterationID = A.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($breeds, $alterations);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 8 - Search for ----Gene----Trait----
    if ($breedCount == 0 && $geneCount > 0 && $altCount == 0 && $traitCount > 0){
        $sql = 'SELECT G.ID AS GeneID, G.GeneName, T.ID AS TraitID, T.TraitDescription, A.ID AS AlterationID, A.AlterationDesc 
                FROM Gene G
                LEFT JOIN AssociatedGene AG ON G.ID = AG.GeneID
                LEFT JOIN Alteration A ON A.ID = AG.AlterationID
                LEFT JOIN AssociatedTraits ATs ON ATs.AlterationID = A.ID
                LEFT JOIN Trait T ON ATs.TraitID = T.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($genes, $traits);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Gene</th>
                <th scope="col">Trait</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 9 - Search for ----Gene----Alteration----
    if ($breedCount == 0 && $geneCount > 0 && $altCount > 0 && $traitCount == 0){
        $sql = 'SELECT G.ID AS GeneID, G.GeneName, A.ID AS AlterationID, A.AlterationDesc 
                FROM Gene G
                LEFT JOIN AssociatedGene AG ON G.ID = AG.GeneID
                LEFT JOIN Alteration A ON A.ID = AG.AlterationID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($genes, $alterations);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Gene</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 10 - Search for ----Alteration----Trait----
    if ($breedCount == 0 && $geneCount == 0 && $altCount > 0 && $traitCount > 0){
        $sql = 'SELECT A.ID AS AlterationID, A.AlterationDesc, T.ID AS TraitID, T.TraitDescription 
                FROM Alteration A
                LEFT JOIN AssociatedTraits ATs ON A.ID = ATs.AlterationID
                LEFT JOIN Trait T ON ATs.TraitID = T.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($alterations, $traits);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">DNA Alteration</th>
                <th scope="col">Trait</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 11 - Search for ----Breed----Gene----Trait----
    if ($breedCount > 0 && $geneCount > 0 && $altCount == 0 && $traitCount > 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, G.ID AS GeneID, G.GeneName, T.ID AS TraitID, T.TraitDescription, A.ID AS AlterationID, A.AlterationDesc 
                FROM Breed B
                LEFT JOIN AssociatedBreed AB ON B.ID = AB.BreedID
                LEFT JOIN Alteration A ON AB.AlterationID = A.ID
                LEFT JOIN AssociatedGene AG ON A.ID = AG.AlterationID
                LEFT JOIN Gene G ON G.ID = AG.GeneID
                LEFT JOIN AssociatedTraits ATs ON ATs.AlterationID = A.ID
                LEFT JOIN Trait T ON ATs.TraitID = T.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($breeds, $genes, $traits);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Gene</th>
                <th scope="col">Trait</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 12 - Search for ----Breed----Alteration----Trait----
    if ($breedCount > 0 && $geneCount == 0 && $altCount > 0 && $traitCount > 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, T.ID AS TraitID, T.TraitDescription, A.ID AS AlterationID, A.AlterationDesc 
                FROM Breed B
                LEFT JOIN AssociatedBreed AB ON B.ID = AB.BreedID
                LEFT JOIN Alteration A ON AB.AlterationID = A.ID
                LEFT JOIN AssociatedTraits ATs ON ATs.AlterationID = A.ID
                LEFT JOIN Trait T ON ATs.TraitID = T.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($breeds, $alterations, $traits);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Trait</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 13 - Search for ----Gene----Alteration----Trait----
    if ($breedCount == 0 && $geneCount > 0 && $altCount > 0 && $traitCount > 0){
        $sql = 'SELECT G.ID AS GeneID, G.GeneName, T.ID AS TraitID, T.TraitDescription, A.ID AS AlterationID, A.AlterationDesc 
                FROM Gene G
                LEFT JOIN AssociatedGene AG ON G.ID = AG.GeneID
                LEFT JOIN Alteration A ON AG.AlterationID = A.ID
                LEFT JOIN AssociatedTraits ATs ON ATs.AlterationID = A.ID
                LEFT JOIN Trait T ON ATs.TraitID = T.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($genes, $alterations, $traits);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Gene</th>
                <th scope="col">Trait</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 14 - Search for ----Breed----Gene----Alteration----
    if ($breedCount > 0 && $geneCount > 0 && $altCount > 0 && $traitCount == 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, G.ID AS GeneID, G.GeneName, A.ID AS AlterationID, A.AlterationDesc 
                FROM Breed B
                LEFT JOIN AssociatedBreed AB ON B.ID = AB.BreedID
                LEFT JOIN Alteration A ON AB.AlterationID = A.ID
                LEFT JOIN AssociatedGene AG ON A.ID = AG.AlterationID
                LEFT JOIN Gene G ON G.ID = AG.GeneID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($breeds, $genes, $alterations);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Gene</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }
    //  Case 15 - Search for ----ALL----
    if ($breedCount > 0 && $geneCount > 0 && $altCount > 0 && $traitCount > 0){
        $sql = 'SELECT B.ID AS BreedID, B.BreedName, G.ID AS GeneID, G.GeneName, T.ID AS TraitID, T.TraitDescription, A.ID AS AlterationID, A.AlterationDesc 
                FROM Breed B
                LEFT JOIN AssociatedBreed AB ON B.ID = AB.BreedID
                LEFT JOIN Alteration A ON AB.AlterationID = A.ID
                LEFT JOIN AssociatedGene AG ON A.ID = AG.AlterationID
                LEFT JOIN Gene G ON G.ID = AG.GeneID
                LEFT JOIN AssociatedTraits ATs ON ATs.AlterationID = A.ID
                LEFT JOIN Trait T ON ATs.TraitID = T.ID
                WHERE (';
        $types = "";
        for ($i = 0; $i < $breedCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . 'B.BreedName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR B.BreedName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $geneCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (G.GeneName LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR G.GeneName LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $traitCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (T.TraitDescription LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR T.TraitDescription LIKE CONCAT("%", ? , "%")';
            }
        }
        for ($i = 0; $i < $altCount; $i++){
            $types = $types . 's';
            if ($i == 0){
                $sql = $sql . ') AND (A.AlterationDesc LIKE CONCAT("%", ? , "%")'; 
            }
            else{
                $sql = $sql . ' OR A.AlterationDesc LIKE CONCAT("%", ? , "%")';
            }
        }
        $sql = $sql . ');';
        $arr = array_merge($breeds, $genes, $traits, $alterations);
        $result = selectFromSQL($types, $arr, $sql);
        $inc = 1;
        echo '<thead>
                <th scope="col">#</th>
                <th scope="col">Breed</th>
                <th scope="col">Gene</th>
                <th scope="col">Trait</th>
                <th scope="col">DNA Alteration</th>
            </thead>
            <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)){
            $traitDesc = htmlspecialchars($row['TraitDescription'], ENT_QUOTES, 'UTF-8');
            $alterationDesc = htmlspecialchars($row['AlterationDesc'], ENT_QUOTES, 'UTF-8');
            $breedName = htmlspecialchars($row['BreedName'], ENT_QUOTES, 'UTF-8');
            $geneName = htmlspecialchars($row['GeneName'], ENT_QUOTES, 'UTF-8');
            echo '<tr>
                    <td>' . $inc . '</td>
                    <td><a href="Breed?id=' . $row['BreedID'] . '&name=' . $breedName . '">' . $breedName . '</a></td>
                    <td><a href="Gene?id=' . $row['GeneID'] . '&name=' . $geneName . '">' . $geneName . '</a></td>
                    <td><a href="Trait?id=' . $row['TraitID'] . '&name=' . $traitDesc . '">' . $traitDesc . '</a></td>
                    <td><a href="Alteration?id=' . $row['AlterationID'] . '&name=' . $alterationDesc . '">' . $alterationDesc . '</a></td>
                </tr>';
            $inc++;
        }
        echo '</tbody>';
    }





?>