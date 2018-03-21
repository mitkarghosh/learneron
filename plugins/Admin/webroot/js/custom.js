/* multiple checkbox function */
  function checkbox(number,functionName,textName,blockFunction,blockTextName,unBlockFunction,unBlockTextName){
    if(typeof textName === 'undefined'){
        checkbox.prototype.text = 'Delete Selected';
    }else{
      checkbox.prototype.text = textName;
    }
    if(typeof blockTextName === 'undefined'){
        checkbox.prototype.blockText = 'Block';
    }else{
      checkbox.prototype.blockText = blockTextName;
    }
    if(typeof unBlockTextName === 'undefined'){
        checkbox.prototype.unBlockText = 'Un-Block';
    }else{
      checkbox.prototype.unBlockText = unBlockTextName;
    }
    checkbox.prototype.totalRecords = number;
    checkbox.prototype.messageDivClass = 'selectMsg';
    var selectAllBtn = 0;
    if($('#select-all-items input').length){
      $('#select-all-items input').on('change',function(){
          if(this.checked){
            selectAllBtn = 1;
            $('.title-description').after('<p class="checkoptions title-description"></p>');
            if($('.pagination li').length > 2){
              $('.checkoptions').html('<div class="selectMsg">'+$('.table-data').length+' records selected. <a href="javascript:selectAll('+number+')">Select all '+number+' records?</a></div>');
            }else{
              $('.checkoptions').html('<div class="selectMsg">'+$('.table-data').length+' records selected.');
            }
            $('.title-search-block h3.title a:last-child').after('<a style="margin-left: 5px;" href="javascript:'+functionName+'();" class="btn btn-danger btn-sm rounded-s delete_btn">'+checkbox.prototype.text+'</a>');
            if(typeof blockFunction !== 'undefined' && blockFunction != false){
              $('.title-search-block h3.title a:last-child').after('<a style="margin-left: 5px;" href="javascript:'+blockFunction+'()" class="btn btn-warning btn-sm rounded-s block_btn">'+checkbox.prototype.blockText+'</a>');
            }
            if(typeof unBlockFunction !== 'undefined' && unBlockFunction != false){
              $('.title-search-block h3.title a:last-child').after('<a style="margin-left: 5px;" href="javascript:'+unBlockFunction+'()" class="btn btn-warning btn-sm rounded-s un_block_btn">'+checkbox.prototype.unBlockText+'</a>');
            }
          }else{
            if($('.checkoptions').length){
              $('.checkoptions').remove();
            }
            $('.delete_btn').remove();
            $('.block_btn').remove();
            $('.un_block_btn').remove();
          }
          var id = [];
          $('#select-all-items input').parents('li').siblings().find(':checkbox').each(function(){
                id.push($(this).val());
            });
          checkbox.prototype.id = id;
      });
    }else{
      selectAllBtn = 0;
    }
    $('.card').find('input[type="checkbox"]').on('change',function(){
        if(this.checked){
          if($('.delete_btn').length){
            $('.delete_btn').remove();
            $('.block_btn').remove();
            $('.un_block_btn').remove();
          }
          $('.title-search-block h3.title a:last-child').after('<a style="margin-left: 5px;" href="javascript:'+functionName+'()" class="btn btn-danger btn-sm rounded-s delete_btn">'+checkbox.prototype.text+'</a>');
          if(typeof blockFunction !== 'undefined'){
            $('.title-search-block h3.title a:last-child').after('<a style="margin-left: 5px;" href="javascript:'+blockFunction+'()" class="btn btn-warning btn-sm rounded-s block_btn">'+checkbox.prototype.blockText+'</a>');
          }
          if(typeof unBlockFunction !== 'undefined' && unBlockFunction != false){
            $('.title-search-block h3.title a:last-child').after('<a style="margin-left: 5px;" href="javascript:'+unBlockFunction+'()" class="btn btn-warning btn-sm rounded-s un_block_btn">'+checkbox.prototype.unBlockText+'</a>');
          }
        }else{
          if(!$('#select-all-items input').parents('li').siblings().find(':checked').length){
            $('.delete_btn').remove();
            $('.block_btn').remove();
            $('.un_block_btn').remove();
          }
          selectAllBtn = 0;
          $('#select-all-items input').attr('checked',false);
          if($('.checkoptions').length){
              $('.checkoptions').remove();
            }
        }
        if(!selectAllBtn){
          var id = [];
          $('#select-all-items input').parents('li').siblings().find(':checked').each(function(){
                id.push($(this).val());
            });
          checkbox.prototype.id = id;
        }
      });
  }

  function selectAll(number){
      checkbox.prototype.id = 'all';
      $('.checkoptions').html('<div class="selectMsg">'+number+' records selected.&nbsp;<a href="javascript:undo('+number+')">Undo?</a></div>');
  }

  function undo(number){
      var id = [];
      $('#select-all-items input').parents('li').siblings().find(':checked').each(function(){
            id.push($(this).val());
        });
      checkbox.prototype.id = id;
      $('.checkoptions').html('<div class="selectMsg">'+$('.table-data').length+' records selected. <a href="javascript:selectAll('+number+')">Select all '+number+' records?</a></div>');
  }

  checkbox.prototype.showMessage = function(msg,type){
    if(!$('.checkoptions').length){
      $('.title-description').after('<p class="checkoptions title-description text-'+type+'"></p>');
    }else{
      $('.checkoptions').removeClass(function (index, css) {
           return (css.match (/(^|\s)text\S+/g) || []).join(' ');
        });
      $('.checkoptions').addClass('text-'+type);
    }
    $('.checkoptions').html('<div class="selectMsg">'+msg+'</div>');
  }

  checkbox.prototype.removeMessage = function(msg){
    $('.checkoptions').remove();
  }

/*
Usage
Eg: var data1 = new checkbox(<?php echo $this->Paginator->param('count'); // total records ?>,'callback function Name');
get delete records id as 1,2,3 or if all records need to delete than "all" using data1.id
total records data1.totalRecords
data1.showMessage("your message") to show message
data1.removeMessage() to remove message
data1.text to change delete name
*/