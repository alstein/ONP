{include file=$header_start} 
{include file=$header_end}
  <!-- Maincontent starts -->

  <section id="maincont" class="ovfl-hidden">
 
    <section class="grybg">
      <!--<div class="pagehead">
        <div class="grpcol">

          <h1 class="cms headingmain">{$title}</h1>
        </div>
      </div>-->
	  <div class="faq">
	  <h1>FAQ</h1>
{include file=$help_left} 
	  <div class="right-txt fl" style="padding-left:20px">

	<ul class="reset ovfl-hidden blog_div">
		{section name=i loop=$faq} 
			
			<li>
				<div class="fl">{$smarty.section.i.iteration}.&nbsp;&nbsp;</div><span class="heading_text"><b>{$faq[i].q|nl2br|stripcslashes|stripcslashes|html_entity_decode}</b></span>
			</li>
			<li style="padding-left:30px;">
				<span class="heading_text">{$faq[i].a|stripcslashes|stripcslashes|html_entity_decode}</span>
			</li>
			<div class="clr" style="height:10px;"></div>
		{/section}
                 </ul>

		</div>
	  </div>
     <!-- <div class="innerdesc">
	
      </div>-->

      <div class="innerdesc">
               <!-- {*if $array_cate}
			<ul class=" ovfl-hidden listin margin_bottom">
				{section name=sec loop=$array_cate}
				<li>
				<a href="#cate{$array_cate[sec].c_id}" >{$array_cate[sec].name}</a>
				</li><br> 
				{/section}
			</ul>
                {/if*}-->

	    <!--<div style="height:20px;"></div>-->

           <!-- {if $array_cate}
            {section name=sec loop=$array_cate}-->
           <!-- <div>
              {if $array_cate[sec].ques}
		<h3> 
			<dt class="cat_heading_text" id="cate{$array_cate[sec].c_id}">{$array_cate[sec].name}</dt>
		</h3><br>

		<ul class="reset ovfl-hidden blog_div">
		{section name=i loop=$array_cate[sec].ques} 
			<li>
			<span class="heading_text">{$array_cate[sec].ques[i].question|stripcslashes|stripcslashes|html_entity_decode}</span>
	
			{section name=m loop=$array_cate[sec][i].ans}
					<p>{$array_cate[sec][i].ans[m].answer|stripcslashes|stripcslashes|html_entity_decode}</p>
			{/section}
			</li>
			<div class="clr" style="height:10px;"></div>
		{/section}
                 </ul>
              {/if} </div>
            {/section}
             
            {/if}
      </div>-->

      <div class="clr">&#x00A0;</div>
    </section>
    <section class="grybg">
      <div class="tphwrks">
	{include file=$footer_free_coupons}
      </div>
    </section>
  </section>
  <!-- Maincontent ends -->
{include file=$footer}