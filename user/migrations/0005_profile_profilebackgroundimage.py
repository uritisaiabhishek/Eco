# Generated by Django 4.0.1 on 2022-07-23 17:02

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('user', '0004_profile_dob_profile_gitlink_profile_location'),
    ]

    operations = [
        migrations.AddField(
            model_name='profile',
            name='profilebackgroundImage',
            field=models.ImageField(null=True, upload_to=''),
        ),
    ]
