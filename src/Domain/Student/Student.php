<?php

namespace Alura\Calisthenics\Domain\Student;

use Alura\Calisthenics\Domain\Video\Video;
use DateTimeInterface;
use Ds\Map;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;
use PHPUnit\Framework\ExecutionOrderDependency;

class Student
{
    private string $email;
    private DateTimeInterface $birthDate;
    private WatchedVideos $watchedVideos;
    private FullName $fullName;
    private Endereco $endereco;

    public function __construct(string $email, DateTimeInterface $birthDate, FullName $fullName, Endereco $endereco)
    {
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->watchedVideos = new WatchedVideos();
        $this->fullName = $fullName;
        $this->endereco = $endereco;
    }

    public function fullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param WatchedVideos $watchedVideos
     */
    public function setWatchedVideos(WatchedVideos $watchedVideos): void
    {
        $this->watchedVideos = $watchedVideos;
    }

    /**
     * @param DateTimeInterface $birthDate
     */
    public function setBirthDate(DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @param FullName $fullName
     */
    public function setFullName(FullName $fullName): void
    {
        $this->fullName = $fullName;
    }

    private function setEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $this->email = $email;
        } else {
            throw new \InvalidArgumentException('Invalid e-mail address');
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->put($video, $date);
    }

    public function hasAccess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
            return true;
        }

        $this->watchedVideos->sort(fn(DateTimeInterface $dateA, DateTimeInterface $dateB) => $dateA <=> $dateB);
        /** @var DateTimeInterface $firstDate */
        $firstDate = $this->watchedVideos->first()->value;
        $today = new \DateTimeImmutable();

        return $firstDate->diff($today)->days < 90;
    }

    public function age(): int
    {
        $today = new \DateTimeImmutable();
        $dateInterval = $this->birthDate->diff($today);

        return $dateInterval->y;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }
}
