# Generated by Django 4.0.1 on 2022-07-23 16:59

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('user', '0003_alter_post_image_profile'),
    ]

    operations = [
        migrations.AddField(
            model_name='profile',
            name='dob',
            field=models.DateField(null=True),
        ),
        migrations.AddField(
            model_name='profile',
            name='gitlink',
            field=models.URLField(null=True),
        ),
        migrations.AddField(
            model_name='profile',
            name='location',
            field=models.TextField(null=True),
        ),
    ]
