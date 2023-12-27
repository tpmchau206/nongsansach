// phân trang danh mục
// buoc 1 tinh tong so ban ghi
$total= mysqli_num_rows($category);
// buoc 2 thiet lap so ban ghi tren 1 trang
$limit=3;
// buoc 3 tinh so trang 
$page=ceil($total/$limit);
// buoc 4 lay trang hien tai
$cr_page = (isset($_GET['page'])? $_GET['page'] : 1);
// buoc 4 tinh start
$start =($cr_page - 1)*$limit;
// buoc 5 query du lieu
$category = mysqli_query($connect, "SELECT * FROM nongsansach.danhmuc LIMIT $start,$limit");
<nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if($cr_page - 1 >0){?>
                        <li class="page-item">
                        <a class="page-link" href="category.php?page=<?php echo $cr_page - 1 ?>">Previous</a>
                        </li>
                        <?php } ?>
                        <?php for ($i = 1; $i <=$page; $i++) {?>
                            <li class="page-item <?php echo (($cr_page == $i)? 'active': '' )?>"><a class="page-link" href="category.php?page=<?php echo $i?>"><?php echo $i ?></a></li> 
                            <?php }?>
                        <?php if($cr_page + 1 <=$page){?>
                        <li class="page-item">
                        <a class="page-link" href="category.php?page=<?php echo $cr_page + 1 ?>">Next</a>
                        </li>
                        <?php } ?>
                    </ul>
                    </nav>