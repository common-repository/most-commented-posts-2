<p>
<label for="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_title"> Widget title </label>
<input type="text" name="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_title" value="<?php echo $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_title"]; ?>" id="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_title"><br /><br />
<label for='<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_number'>Number of Posts to show</label>
<input style="width:30px" type="text" name="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_number" value="<?php echo $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_number"]; ?>" id="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_number"><br /><br />
<label for="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_period">Period</label>
<select name="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_period" id="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_period">
<option value="w" <?php echo self::isSelected("w", $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_period"]);?>>This Week</option>
<option value="m" <?php echo self::isSelected("m", $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_period"]);?>>This Month</option>
<option value="Y" <?php echo self::isSelected("Y", $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_period"]);?>>This Year</option>

</select>
<input type="hidden" name="<?php echo $anderson_makiyama[self::PLUGIN_ID]->plugin_slug?>_submit" value="1" />
</p>
<p>
<ul>
<li>Visit Plugin's page: <a href="<?php echo self::PLUGIN_PAGE ?>" target="_blank"><?php echo self::PLUGIN_NAME ?></a>
</li>
<li>
Visit Autor's blog: <a href="http://blogwordpress.ws" target="_blank">Anderson Makiyama</a>
</li>
</ul>
</p>