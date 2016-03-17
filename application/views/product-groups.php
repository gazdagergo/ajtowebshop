                <?php if ($group_members != false) : ?>
                
                <form method="post" action="" class="valaszto_form">
                    
                    <input type="hidden" name="call_main_function" value="goToGroupMember">
                    
                    <div class="select-style termekcsoportok">
                        
                        <select name="group_member">

                        <?php foreach ($group_members as $member) :
                            $url_string = empty($member->url_string) ? $member->id : $member->url_string; 
                         ?>

                        <option <?php

                                if ($this->uri->segment(2) == $member->url_string) echo "selected";

                                ?> value="<?php echo $member->url_string; ?>"><?php echo $member->short_description; ?></option>

                        <?php endforeach; ?>

                        </select>

                    </div>
                       
                </form>
                    
                
                <?php endif; ?>     