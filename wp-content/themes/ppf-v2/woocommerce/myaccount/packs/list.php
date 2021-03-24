<?php $challenge_packs = pp_get_challenge_packs(get_current_user_id()); ?>

<form action="" id="create_pack">

    <table width="100%" class="packs-table" cellpadding="10" cellspacing="0">

        <thead>
        <tr>
            <th align="left">Challenge Pack Title</th>
            <th align="left" width="200px">Date Created</th>
            <th align="left" width="130px">No. Activities</th>
            <th align="center" width="100px">Actions</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach($challenge_packs as $challenge_pack){ ?>

            <tr>
                <td>
                    <a href="<?php echo esc_url(add_query_arg(array('action' => 'edit' , 'id' => $challenge_pack->uid) , site_url('my-account/packs'))) ?>">
                        <?=$challenge_pack->name?>
                    </a>
                </td>
                <td align="left"><?=date('dS F Y H:i' , strtotime($challenge_pack->date_created))?></td>
                <td align="left"><?=count(unserialize($challenge_pack->activities))?></td>
                <td align="center" style="text-align: center !important;">
                    <a target="_blank" href="<?php echo esc_url(add_query_arg(array('challenge_id' => $challenge_pack->uid) , site_url('print-pack'))) ?>" title="Download Challenge Pack"><img width="20px" src="<?php echo get_template_directory_uri().'/assets/icons/noun_Save_2209758.svg' ?>" alt=""></a>
                    <a href="<?php echo esc_url(add_query_arg(array('action' => 'edit' , 'id' => $challenge_pack->uid) , site_url('my-account/packs'))) ?>" title="Edit Challenge Pack"><img width="20px" src="<?php echo get_template_directory_uri().'/assets/icons/noun_Pencil_3011921.svg' ?>" alt=""></a>
                    <a class="delete_challenge_pack" data-id="<?=$challenge_pack->uid?>" href="javascript:void(0);" title="Remove Challenge Pack"><img width="20px" src="<?php echo get_template_directory_uri().'/assets/icons/noun_Close_659815 (1).svg' ?>" alt=""></a>
                </td>
            </tr>

        <?php } ?>

        </tbody>

        <tfoot>
        <tr>
            <td colspan="3"><input type="text" required name="_new_pack_name" placeholder="Type here to create a new custom challenge pack"></td>
            <td style="text-align: center !important;">
                <button type="submit" style="background:none !important;"><img width="20px" src="<?php echo get_template_directory_uri().'/assets/icons/noun_tick_2495473.svg' ?>" alt=""></button>
            </td>
        </tr>
        </tfoot>

    </table>

</form>

<script>

    $ = jQuery;

    $('body').on('submit' , '#create_pack' , function () {

        var data = {
            action : 'pp_create_challenge_pack',
            user_id : <?=get_current_user_id()?>,
            name : $('input[name="_new_pack_name"]').val()
        };

        $.post('<?=admin_url()?>admin-ajax.php' , data , function (res) {

            var json = JSON.parse(res);
            var id = json.id;
            var uid = json.uid;

            window.location.href = $('link[rel="canonical"]').attr('href')+'/packs/?action=edit&id='+uid;

        });

        return false;

    });

    $('.delete_challenge_pack').click(function () {

        if (confirm('Are you sure you want to delete this pack?')) {

            var data = {
                action : 'deleteChallengePack',
                challenge_pack_id: $(this).data('id')
            };

            $.post('<?=admin_url()?>admin-ajax.php' , data , function (res) {
                window.location.reload();
            });

        } else {

        }

    });

</script>
