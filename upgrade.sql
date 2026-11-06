-- Run once on an existing `clubunimy` database to apply the ClubHub fixes.
-- (Fresh installs from clubunimy.sql already include these changes.)

-- New registrations failed because id_user was not auto-increment.
ALTER TABLE `user` MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

-- Registration time, used for the "Recent registrations" panel.
ALTER TABLE `user` ADD COLUMN `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- The limit row had an empty id, so its edit link never worked.
UPDATE `limitseminar` SET `id_limit2` = '1' WHERE `id_limit2` = '' OR `id_limit2` IS NULL;

-- Email templates were limited to 200 characters.
ALTER TABLE `email` MODIFY `body_email` text NOT NULL, MODIFY `altbody_email` text NOT NULL;
