雷劈网 WEB表单设计器
==========
<h3>简介</h3>
<p>Ueditor Formdesign Plugins leipi.org</p>
<p>百度Ueditor表单设计器扩展插件，开源免费表单设计器，它通常在、OA系统、问卷调查系统、考试系统、等领域发挥着重要作用，你可以在此基础上任意修改使功能无限强大！</p>
<br/>
交流 Q群：143263697<br/>
官网DEMO：http://formdesign.leipi.org<br/>
开发文档：http://formdesign.leipi.org/doc.html<br/>
<hr/>
<h3>雷劈网相关产品</h3>
<ul>
	<li><a href="http://flowdesign.leipi.org/" target="_blank">流程设计器</a></li>
	<li><a href="http://qrcode.leipi.org/" target="_blank">js自动生成二维码</a></li>
	<li><a href="http://git.leipi.org/" target="_blank">雷劈网git列表</a></li>
</ul>
<hr/>
<h2>已提供语言</h2>
<ul>
	<li><a href="http://formdesign.leipi.org/" target="_blank">PHP</a></li>
	<li><a href="http://formdesign.leipi.org/downloads.html#java" target="_blank">JAVA</a></li>
	<li>.NET(准备中)</li>
</ul>
<hr/>
<h2>目录说明</h2>
<table class="table table-hover">
        <tr>
            <th width="10%">名称</th>
            <th width="10%">描述</th>
        </tr>
        <tr>
            <td>1. Formdesign4_1</td>
            <td>仅插件，要自行安装到Ueditor（适合升级，不适合入门）</td>
        </tr>
	<tr>
            <td>2. Formdesign4_1_GBK</td>
            <td>GBK编码，仅插件，要自行安装到Ueditor（适合升级，不适合入门）</td>
        </tr>
	<tr>
            <td>3. Formdesign4_1_Ueditor1_4_2</td>
            <td>已安装好Formdesign的Ueditor，无需另外下载UE（适合入门）</td>
        </tr>
	<tr>
            <td>4. Formdesign4_1_Ueditor1_4_2_Thinkphp3_2</td>
            <td>PHP官网示例，使用Thinkphp框架 + Ueditor + Formdesign（更适合入门，学会如何运用，其它语言可参考）</td>
        </tr>
	<tr>
            <td>5. Formdesign4_1_Ueditor1_4_3[新]</td>
            <td>已安装好Formdesign的Ueditor1.4.3(不承诺支持ie6/7)，无需另外下载UE（适合入门）</td>
        </tr>
      
    </table>

<hr/>
<div class="row well">
    <h2>Formdesign 4.1.x <small>主要更新日志</small></h2>
     <p>
        <strong>更新时间：2014 / 12 / 07</strong>
        <br/>
        <ol>
            <li>修复IE下 单选和复选，预览时无法显示默认选中状态<br/>
			主要修改 parse_form 的2处 checked 处理<br/>
			//if(!option['checked']) option['checked'] = ''; 注释掉这行<br/>
            var checked = option['checked'] !=undefined ? 'checked="checked"' : '';//这里使用undefined来判断<br/>

			</li>
		
        </ol>
     </p>
    <p>
        <strong>更新时间：2014 / 12 / 07</strong>
        <br/>
        <ol>
            <li修复IE下 单选和复选，预览时无法显示默认选中状态</li>
        </ol>
     </p>

	 <p>
        <strong>更新时间：2014 / 12 / 06</strong>
        <br/>
        <ol>
            <li>新增：java的示例，由snakerflow提供</li>
        </ol>
     </p>
    <p>
        <strong>更新时间：2014 / 09 / 19</strong>
        <br/>
        <ol>
            <li>新增：列表控件，升级文件<code>leipi.formdesign.v4.js</code>、<code>listctrl.html</code></li>
            <li>新增：Ueditor1.4.3示例</li>
        </ol>
     </p>
     <p>
        <strong>更新时间：2014 / 09 / 14</strong>
        <br/>
        <ol>
            <li>仅更新了  <code>leipi.formdesign.v4.js</code>（复选组、下拉组在IE下的bug、下拉控件在Firefox中的bug）、<code>leipi.html</code>(在Firefox中的bug)</li>
            <li>感谢<b> 绝版男爵、Mr ′Li </b>及时反馈。</li>
        </ol>
     </p>
     <p>
        <strong>更新时间：2014 / 8 / 21 (两次更新)</strong>
        <br/>
        <ol>
            <li>仅更新了 parse_form 的正则匹配标签顺序影响结果的Bug</li>
            <li>感谢<b> 枫叶红了 </b>及时反馈。</li>
        </ol>
     </p>
    <p>
        <strong>更新时间：2014 / 8 / 15</strong>
        <br/>
        <ol>
            <li>更新了parse_form的正则匹配在IE下不正确的Bug</li>
            <li>感谢<b> Laughing.、枫叶红了 </b>及时反馈。</li>
        </ol>
     </p>
     <p>
        <strong>更新时间：2014 / 8 / 9</strong>
        <br/>
        <ol>
            <li>抱歉，4.0 【单选与复选】算法均存在Bug，请更新 parse_form解析算法和radios.html和checkboxs.html两个文件</li>
            <li>感谢Mr.Hannibal及时反馈。</li>
        </ol>
     </p>

   
</div>
<div class="alert alert-error">
    <a href="http://formdesign.leipi.org/downloads/history.html">查看历史版本</a>
</div>