<link rel='stylesheet' href='header.css?token=<?php echo time(); ?>'>
<p onclick="location.href='/'">UBook Store</p>
<div id="header-wrap">
    <div id="header">
        <ul>
            <li onclick="openNav(event)" class="" selected="false">
                <div class="line line1"></div>
                <div class="line line2"></div>
                <div class="line line3"></div>
            </li>
            <li onclick="moveToCategories(event,'category')" category="parent">Categories
                <ul>
                <?php
                    $sql="select distinct(degree) from categories";
                    $result=$conn->query($sql);
                    if($result->num_rows>0) {
                        while($row=$result->fetch_assoc()) {
                            echo '<li onclick="moveToCategories(event,\'degree\')"><span>'.$row['degree'].'</span>';
                            $sql1="select distinct(branch) from categories where degree='".$row['degree']."'";
                            $result1=$conn->query($sql1);
                            if($result1->num_rows>0) {
                                echo "<ul>";
                                while($row1=$result1->fetch_assoc()) {
                                    echo '<li onclick="moveToCategories(event,\'branch\')"><span>'.$row1['branch'].'</span></li>';
                                }
                                echo "</ul>";
                            }
                            echo "</li>";
                        }
                    } else {
                        echo "no results";
                    }
                ?>
                </ul>
            </li>
            <li onclick="location.href='/dashboard.php?action=buy'">New Arrivals</li>
            <li onclick="location.href='/dashboard.php?action=sell'">Sell</li>
            <?php
                if(isset($_SESSION['email']) && $_SESSION['email']==="admin@bookstore.com") {
                    echo '<li onclick="location.href=\'/dashboard.php?action=uploadrequests\'">Upload Requests</li>';
                }
            ?>
        </ul>
        <ul id="header-member-options">
            <li onclick="showSearch()"><i class="fas fa-search"></i></li>
            <?php
                if(!$_isLoggedin)
                    echo '<li onclick="showAuthBox()">Login/Signup</li>';
                else {
                    echo '<li onclick="location.href=\'/dashboard.php?action=cart\'"><i id="header-cart-icon" class="fas fa-shopping-cart"><span id="header-cart-count"></span></i></li>
                    <li onclick="location.href=\'/dashboard.php?action=requests\'"><i  id="header-req-icon" class="fas fa-inbox"><span id="header-req-count"></span></i></li>
                    <li onclick="location.href=\'/dashboard.php?action=notifications\'"><i id="header-notif-icon" class="fas fa-bell"><span id="header-notif-count"></span></i></li>
                    <li><h6 onclick="location.href=\'/dashboard.php?action=profile\'">'.$_SESSION['fullname'].'</h6><li><li><a href="logout.php">Logout</a></li>';
                }
            ?>
			<div id="search-wrap" style="display:none">
                <div id="search">
                    <i class="fas fa-search"></i><input id="fullScreenSearch" type="text" placeholder="Start typing here.." >
                    <i class="fas fa-close" onclick="closeSearch()"></i>
                </div>
                <ul id="search-result">

                </ul>
            </div>
        </ul>

    </div>
</div>
<div id="side-nav">
    <a href="/dashboard.php?action=category&type=readingmaterial">Reading Material</a>
    <a href="/dashboard.php?action=category&type=programmingcodes">Programming Codes</a>
    <a href="/dashboard.php?action=category&type=questionpapers">Question Papers</a>
    <a onclick="location.href='/dashboard.php?action=buy'" class="hiddenSideNavItem">New Arrivals</a>
    <a onclick="location.href='/dashboard.php?action=sell'"  class="hiddenSideNavItem">Sell</a>
    <a onclick="location.href='/dashboard.php?action=donate'"  class="hiddenSideNavItem">Donate</a>
    <div>
        <span onclick="location.href='/dashboard.php?action=category&type=book'">Categories</span>
        <div>
            <?php
                $sql="select distinct(degree) from categories";
                $result=$conn->query($sql);
                if($result->num_rows>0) {
                    while($row=$result->fetch_assoc()) {
                        echo '<span onclick="moveToCategories(event,\'degree\')">'.$row['degree'].'</span>';
                        $sql1="select distinct(branch) from categories where degree='".$row['degree']."'";
                        $result1=$conn->query($sql1);
                        if($result1->num_rows>0) {
                            echo "<div>";
                            while($row1=$result1->fetch_assoc()) {
                                echo '<a onclick="moveToCategories(event,\'branch\')"><span>'.$row1['branch'].'</span></a>';
                            }
                            echo "</div>";
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>
<script>
    <?php
        if($_isLoggedin) {
            echo '       var xhttp1 = new XMLHttpRequest();
            xhttp1.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("header-cart-count").textContent=this.responseText;
                }
            };
            xhttp1.open("GET", "countBooks.php", true);
            xhttp1.send();';
        }
    ?>
    function showSearch() {
        document.getElementById("search-wrap").style.display="block";
    }
    function closeSearch() {
        document.getElementById("search-wrap").style.display="none";
    }
    var fullScreenSearch=document.getElementById("fullScreenSearch");
    var fullScreenSearchResult=document.getElementById("search-result");
    fullScreenSearch.addEventListener("change",function() {
        fullScreenSearchResult.innerHTML="";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                fullScreenSearchResult.innerHTML=this.responseText;
            }
        };
        xhttp.open("POST", "searchBook.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("search="+this.value);
    });

    function openNav(event) {
        if(event.target.attributes.selected.nodeValue==="false") {
            event.target.attributes.selected.nodeValue="true";
            event.target.className="selected";
            document.getElementById("side-nav").style.left = "0";
        } else {
            event.target.className="    ";
            event.target.attributes.selected.nodeValue="false";
            document.getElementById("side-nav").style.left = "-320px";
        }
    }
    function moveToCategories(event,type) {
        event.stopPropagation();
        console.log(event.target);
        if(event.target.attributes.category !== undefined)
            location.href='/dashboard.php?action=category&type=book';
        else
            location.href='/dashboard.php?action=category&type=book&'+type+'='+event.target.childNodes[0].textContent;
    }
</script>
