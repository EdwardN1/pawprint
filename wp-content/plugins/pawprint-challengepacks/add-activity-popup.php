<?php
    $activity = $_POST['activity_id'];
    $challenge_packs = pp_get_challenge_packs(get_current_user_id());
?>
<div class="activity-add-to-pack-popup">
    <div class="vert">
        <div class="inner">
            <div class="close-button">x</div>
            <form action="" method="post" id="add_to_challengepack">
                <div class="success-msg">
                    The activity has been saved to the challenge pack.
                </div>
                <input type="hidden" name="activity_id" value="<?=$activity?>">
                <h2>Choose which challenge pack you would like to add this activity to.</h2>
                <select name="_pack" id="">
                    <option disabled selected>-- Please Select --</option>
                    <?php
                    foreach ($challenge_packs as $item) {
                        $pack = pp_get_challenge_pack(get_current_user_id() , $item->uid);
                        if(in_array($activity , $pack->activities)){
                            echo '<option disabled value="'.$item->uid.'">'.$item->name.' - Activity already added</option>';
                        }else{
                            echo '<option value="'.$item->uid.'">'.$item->name.'</option>';
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="pp-btn navy">Add to Challenge Pack</button>
            </form>
        </div>
    </div>
</div>