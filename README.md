## @SpEcHiDeStickerBOT

# Fork of [KyleTelegramBot](https://github.com/Kyle2142/PHPBot)

## Requirements

- PHP >= 5.4
- MySQL >= 5.5

## Instructions

- Copy all the PHP files to your webserver.

- Import the database structure to your MySQL database according to `database.sql`.

- Goto [@BotFather](https://t.me/BotFather) and create a new bot.

![STEP_TWO](/README/BotFather_2.png)

![STEP_THREE](/README/BotFather_3.png)

- Enable `inline mode` for the newly created BOT.

![STEP_FOUR](/README/BotFather_4.png)

- Set webhook by going to the following URL

```
https://api.telegram.org/bot<TG_BOT_TOKEN>/setWebhook?url=https://path/to/webhook.php
```

`<TG_BOT_TOKEN>` is the token obtained after running the `/newbot` command.

![STEP_FIVE](/README/SetWebHook_1.png)

- Edit `config.php`, according to your needs.

- Edit the lines in `functions.php`.
  - Line Number: 67
  - Line Number: 71


## Contributing

If you find any feature that you would like to have raise an issue or submit a Merge Request for the change.
