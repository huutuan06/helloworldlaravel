<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 15/08/2018
 * Time: 17:05
 */
?>
<div class="modal fade" id="permissionModalCreate">
    <div class="modal-dialog">
        <div class="modal-content removeDefaultModalStyle">
            <div class="customModalVocabulary">
                <div class="container">
                    <div class="row titleForm">
                        <div class="col-md-4" align="center">
                            <div class="imgSizeLogo">
                                <img src="{{ URL::asset('images/imgLogoLogin.png') }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div  style="margin-top: 15px;">
                                <p class="subTitleForm">English Form</p>
                                <p class="mediumTitleForm">Request for Creating Permission</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="permissionFormCreate" class="form-horizontal form-label-left">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-top: 30px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Permission name: </label>
                        <div class="col-md9 col-sm-9 col-xs-12">
                            <input class="form-control nameTopic" name="permissionname" id="permissionname" placeholder="" type="text">
                        </div>
                    </div>
                    <div class="modal-footer"  style="border: none;">
                        <div class="pull-right">
                            <input class="form-control btnControlForm" type="submit" value="Create">
                        </div>
                        <div class="pull-right" style="margin-right: 10px;">
                            <input class="form-control btnControlForm" type="button" data-dismiss="modal" value="Cancle">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
