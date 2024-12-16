<?php
/*
 * Copyright (c) 2017-2018 THL A29 Limited, a Tencent company. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace TencentCloud\Ecm\V20190719\Models;
use TencentCloud\Common\AbstractModel;

/**
 * ModifyImageAttribute请求参数结构体
 *
 * @method string getImageId() 获取镜像ID，形如img-gvbnzy6f
 * @method void setImageId(string $ImageId) 设置镜像ID，形如img-gvbnzy6f
 * @method string getImageName() 获取设置新的镜像名称；必须满足下列限制：
不得超过20个字符。
- 镜像名称不能与已有镜像重复。
 * @method void setImageName(string $ImageName) 设置设置新的镜像名称；必须满足下列限制：
不得超过20个字符。
- 镜像名称不能与已有镜像重复。
 * @method string getImageDescription() 获取设置新的镜像描述；必须满足下列限制：
- 不得超过60个字符。
 * @method void setImageDescription(string $ImageDescription) 设置设置新的镜像描述；必须满足下列限制：
- 不得超过60个字符。
 */
class ModifyImageAttributeRequest extends AbstractModel
{
    /**
     * @var string 镜像ID，形如img-gvbnzy6f
     */
    public $ImageId;

    /**
     * @var string 设置新的镜像名称；必须满足下列限制：
不得超过20个字符。
- 镜像名称不能与已有镜像重复。
     */
    public $ImageName;

    /**
     * @var string 设置新的镜像描述；必须满足下列限制：
- 不得超过60个字符。
     */
    public $ImageDescription;

    /**
     * @param string $ImageId 镜像ID，形如img-gvbnzy6f
     * @param string $ImageName 设置新的镜像名称；必须满足下列限制：
不得超过20个字符。
- 镜像名称不能与已有镜像重复。
     * @param string $ImageDescription 设置新的镜像描述；必须满足下列限制：
- 不得超过60个字符。
     */
    function __construct()
    {

    }

    /**
     * For internal only. DO NOT USE IT.
     */
    public function deserialize($param)
    {
        if ($param === null) {
            return;
        }
        if (array_key_exists("ImageId",$param) and $param["ImageId"] !== null) {
            $this->ImageId = $param["ImageId"];
        }

        if (array_key_exists("ImageName",$param) and $param["ImageName"] !== null) {
            $this->ImageName = $param["ImageName"];
        }

        if (array_key_exists("ImageDescription",$param) and $param["ImageDescription"] !== null) {
            $this->ImageDescription = $param["ImageDescription"];
        }
    }
}
