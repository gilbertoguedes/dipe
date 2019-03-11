<div class="dropdown-menu">
    <ul>
        <?php
        /*var_dump($category_list);*/
        if ($category_list) {
            foreach ($category_list as $parent_category) {
                $sub_parent_cat =  $this->db->select('*')
                    ->from('product_category')
                    ->where('parent_category_id',$parent_category->category_id)
                    ->order_by('menu_pos')
                    ->get()
                    ->result();
                ?>
                <li>
                    <a href="<?php echo base_url('category/'.$parent_category->category_id)?>" class="<?php if($sub_parent_cat){echo "cat_menu_link";}else{echo "dropdown-item";}?>">
                        <i><img src="<?php echo $parent_category->cat_favicon?>" height="20"></i> <?php echo $parent_category->category_name?></a>
                    <?php
                    if ($sub_parent_cat){
                        ?>
                        <div class="row m0 cat_sub_menu">
                            <?php
                            if ($sub_parent_cat) {
                                foreach ($sub_parent_cat as $parent_cat) {
                                    ?>
                                    <div class="col-sm-4">
                                        <p><a href="<?php echo base_url('category/'.$parent_cat->category_id)?>"><?php echo $parent_cat->category_name?></a></p>
                                        <?php
                                        $sub_cat =  $this->db->select('*')
                                            ->from('product_category')
                                            ->where('parent_category_id',$parent_cat->category_id)
                                            ->order_by('menu_pos')
                                            ->get()
                                            ->result();
                                        if ($sub_cat) {
                                            foreach ($sub_cat as $s_p_cat) {
                                                ?>
                                                <a href="<?php echo base_url('category/'.$s_p_cat->category_id)?>"><?php echo $s_p_cat->category_name?></a>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>
                </li>
            <?php
            }
        }
        ?>
    </ul>
</div>