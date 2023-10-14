<aside class="col-lg-3">
    <div class="card profile_left_card mb-2">
        <div class="card-header fw-bold">Skills</div>
        <div class="card-body">
            <?php
                if(!empty($expertise)){
                    echo '<ol>';
                        foreach ($expertise as $skill){
                            echo '<li>'.$skill.'</li>';
                        }
                    echo '</ol>';
                }else{
                    echo '<span>No expertise selected</span>';
                }
            ?>
        </div>
    </div>
    <?php if(isset($education) && !empty($education)){ ?>
        <div class="card profile_left_card mb-2">
            <div class="card-header fw-bold">Education</div>
            <div class="card-body">
                <p><?php echo $education; ?></p>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($how_can_i_help) && !empty($how_can_i_help)){ ?>
        <div class="card profile_left_card mb-2">
            <div class="card-header fw-bold">How can i help</div>
            <div class="card-body">
                <ul>
                    <?php 
                        $how_can_i_help = explode(',', $how_can_i_help);
                        foreach ($how_can_i_help as $value) {
                            echo '<li>'.$value . '</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($my_traits) && !empty($my_traits)){ ?>
    <div class="card profile_left_card mb-2">
        <div class="card-header fw-bold">My traits</div>
        <div class="card-body">
            <ul>
                <?php 
                    $my_traits = explode(',', $my_traits);
                    foreach ($my_traits as $value) {
                        echo '<li>'.$value . '</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
    <?php } ?>
    <div class="card profile_left_card mb-2">
        <div class="card-header fw-bold">Personal information</div>
        <div class="card-body">
            <ul class="list-unstyled m-0 p-0">
                <?php if (!empty($birthday)) { ?>
                <li>
                    <div class="fa fa-birthday-cake"></div>
                    Birthday :
                        <?php echo $birthday; ?>
                </li>
                <?php } ?>
                <?php if (!empty($location)) { ?>
                <li>
                    <div class="fa fa-map-marker"></div>
                    Location :
                    <?php echo $location; ?>
                </li>
                <?php } ?>
                <?php if (!empty($github_profile)) { ?>
                <li>
                    <div class="fab fa-github"></div>
                    Github :
                    <?php echo $github_profile; ?>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</aside>