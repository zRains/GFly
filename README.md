GFly 
===

#### ![example](https://img.shields.io/badge/version-1.0.0-brightgreen.svg) ![example](https://img.shields.io/badge/release-1.0.0-brightgreen.svg) 

这是一个PocketMine-MP插件。在服务器里可以使得不同玩家拥有飞行权限，可以用作vip用户的特权。目前功能还在完善中。

#### 命令

| 命令                                                         | 作用                                                   | 示例                   | 权限   | 使用范围       |
| ------------------------------------------------------------ | ------------------------------------------------------ | ---------------------- | ------ | -------------- |
| /gfly s  [af \| ab \| gd \| pvp] [true \| false] [players...] | 设置玩家飞行权限和其它其它权限                         | /gfly s  af true zrain | op     | 控制台或游戏内 |
| /gfly  t                                                     | 开启飞行（默认配置文件已设置为玩家加入后自动开启飞行） | /gfly t                | 所有人 | 游戏内         |
| /gfly  i                                                     | 查看自己的权限信息 | /gfly i                | 所有人 | 游戏内         |

缩写命令对照：

| 缩写 | 原型               | 作用                               | 可选值        |
| ---- | ------------------ | ---------------------------------- | ------------- |
| af   | AllowFlight        | 设置玩家是否拥有飞行权限           | true \| false |
| ab   | Allow_Break_Blocks | 设置玩家在飞行时是否能破坏方块     | true \| false |
| gd   | Allow_Get_Damage   | 设置玩家在飞行时是否能受到伤害     | true \| false |
| pvp  | Allow_PVP          | 设置玩家在飞行时是否能攻击其他玩家 | true \| false |

#### 还在开发的内容

- 设置玩家在飞行时是否能受到伤害
- 设置玩家在飞行时是否能进行PVP操作
- 世界黑/白名单
- 设置可飞行时长
- 购买飞行时长（可能要依赖`EconomyAPI`）
- 简便操作的UI界面
- 英文版说明书（毕竟国内有BDS服务端，PM相比以前少了）

#### 关于

插件测试PM核心：PocketMine-MP v3.14.0

插件使用API：3.2.0

配置文件版本：1.0.0

作者：zRain
