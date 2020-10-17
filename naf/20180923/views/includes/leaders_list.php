<div class="leadersOut">
    <!-- <div class="leaders_slider"> -->
    <div class="leadersIn addNew transition">
        <div class="leaderImg">
            <img src="<?php echo base_url()?>assets/images/newLeaderProfile.png" alt="Add New Leader" title="Add New Leader">
        </div>
        <div class="leaderInfo">
        <?php if($langcookie=="en"){ ?>
            <h4>Add New Leader</h4>
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        	<h4>नया नेता जोड़ें </h4>
        <?php }?>
            <!-- <div class="btn transition">Add</div> -->
            <!-- <p>use this option only if you can’t find your leader</p> -->
        </div>
        <input class="checkRadio" type="radio" name="vote">
        <div class="addLeaderName">
        <input class="newLeaderNames" name="new_leader" id="new_leader">
            <!-- <input class="newLeaderNames" list="names" name="new_leader" id="new_leader">
               <datalist id="names" >
               <select style="display: none;">
                <?php 
                foreach ($other_leaders as $key => $value) { ?>
                    <option data-id="<?php echo $value['id'];?>" value="<?php echo $value['full_name'];?>"></option>
                <?php }?>
                </select>
               </datalist>  -->
        </div>
    </div><?php foreach ($featured_leaders as $key => $value) {?><div class="leadersIn transition">
        <div class="leaderImg">
            <img src="<?php echo base_url()?>assets/images/<?php echo $value['image_path']?>" alt="<?php if($langcookie=="en"){ echo $value['full_name']; } if($langcookie=="hi"){ echo $value['full_name_hindi']; } ?>" title="<?php if($langcookie=="en"){ echo $value['full_name']; } if($langcookie=="hi"){ echo $value['full_name_hindi']; } ?>">
        </div>
        <div class="leaderInfo">
            <h4><?php if($langcookie=="en"){ echo $value['full_name']; } if($langcookie=="hi"){ echo $value['full_name_hindi']; } ?></h4>
            <!-- <div class="btn transition vote_leader" data-id="<?php echo $value['id']?>">Vote</div> -->
            <input class="checkRadio" type="radio" name="vote" value="<?php echo $value['id']?>"> 
        </div></div><?php }?>    
                  
        <!-- </div> -->
</div>